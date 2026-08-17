#!/bin/sh
set -e

echo "==> Starting URBANCOFF Laravel Service on Render..."

# Determine PORT (Render assigns dynamic PORT, default 80 if not set)
export PORT=${PORT:-80}
echo "==> Configuring Nginx to listen on port: $PORT"

# Clean default Alpine Nginx includes to prevent conflicting server directives
rm -rf /etc/nginx/http.d/* /etc/nginx/conf.d/*

# Replace ${PORT} placeholder in main Nginx config
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Ensure directory permissions for storage and bootstrap/cache
echo "==> Fixing storage and cache permissions..."
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# SQLite initialization if DB_CONNECTION is sqlite
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    echo "==> Checking SQLite database file at $DB_FILE..."
    if [ ! -f "$DB_FILE" ]; then
        echo "==> Creating new SQLite database file..."
        touch "$DB_FILE"
    fi
    chown www-data:www-data "$DB_FILE"
    chmod 664 "$DB_FILE"
fi

# Ensure APP_KEY exists
if [ -z "$APP_KEY" ]; then
    echo "==> APP_KEY environment variable is empty. Generating temporary key..."
    php artisan key:generate --force || true
fi

# Ensure storage symlink exists
echo "==> Creating storage symlink..."
php artisan storage:link --force || true

# Run database migrations
echo "==> Running migrations..."
php artisan migrate --force --isolated || true

# Auto-seed if AUTO_SEED environment variable is true
if [ "${AUTO_SEED:-false}" = "true" ]; then
    echo "==> Running database seeders..."
    php artisan db:seed --force || true
fi

# Optimize Laravel caching for production
echo "==> Optimizing configuration, routes, and views..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan event:cache || true

echo "==> URBANCOFF Application is ready!"

# If custom command is passed (Worker / Scheduler), execute it
if [ $# -gt 0 ]; then
    echo "==> Executing custom container command: $@"
    exec "$@"
fi

echo "==> Launching Nginx & PHP-FPM Web Service..."
# Execute supervisord for web service
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
