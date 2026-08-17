# ==============================================================================
# Stage 1: Build Frontend Assets (Vite)
# ==============================================================================
FROM node:20-alpine AS frontend-builder
WORKDIR /app

COPY shirt-store/package*.json ./
RUN npm ci --legacy-peer-deps

COPY shirt-store/vite.config.js ./
COPY shirt-store/resources/ ./resources/
COPY shirt-store/public/ ./public/

RUN npm run build

# ==============================================================================
# Stage 2: Composer Dependencies (Production only)
# ==============================================================================
FROM composer:2 AS composer-builder
WORKDIR /app

COPY shirt-store/composer.json shirt-store/composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-autoloader \
    --no-scripts

COPY shirt-store/ .
RUN composer dump-autoload --optimize --no-dev

# ==============================================================================
# Stage 3: Production Runtime
# ==============================================================================
FROM php:8.3-fpm-alpine AS production

LABEL maintainer="URBANCOFF DevOps <devops@urbancoff.com>"
LABEL description="Production Docker image for URBANCOFF Laravel eCommerce Application"

WORKDIR /var/www/html

# Install system dependencies, Nginx, Supervisor, and tools
RUN apk add --no-cache \
    nginx \
    supervisor \
    gettext \
    curl \
    sqlite \
    sqlite-libs \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev

# Install required PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
        pdo \
        pdo_sqlite \
        pdo_mysql \
        pdo_pgsql \
        bcmath \
        ctype \
        fileinfo \
        gd \
        intl \
        mbstring \
        opcache \
        tokenizer \
        xml \
        zip

# Copy PHP and Nginx configuration
COPY shirt-store/docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY shirt-store/docker/nginx.conf /etc/nginx/nginx.conf.template
COPY shirt-store/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY shirt-store/docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application source code
COPY --chown=www-data:www-data shirt-store/ /var/www/html

# Copy prebuilt vendor and frontend assets from previous stages
COPY --from=composer-builder --chown=www-data:www-data /app/vendor /var/www/html/vendor
COPY --from=frontend-builder --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Create necessary directories and set correct permissions
RUN mkdir -p \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    /var/www/html/database \
    /var/log/supervisor \
    /run/nginx && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose default HTTP port
EXPOSE 80 10000

# Health check endpoint
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://127.0.0.1:${PORT:-80}/health || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
