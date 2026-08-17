# ==============================================================================
# Stage 1: Build Frontend Assets (Vite)
# ==============================================================================
FROM node:20-alpine AS frontend-builder
WORKDIR /app

COPY package*.json ./
RUN npm ci --legacy-peer-deps

COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run build

# ==============================================================================
# Stage 2: Composer Dependencies (PHP 8.4 Production only)
# ==============================================================================
FROM php:8.4-cli-alpine AS composer-builder
WORKDIR /app

# Copy Composer 2 binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install essential tools for composer
RUN apk add --no-cache git unzip libzip-dev

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-autoloader \
    --no-scripts

COPY . .
RUN composer dump-autoload --optimize --no-dev

# ==============================================================================
# Stage 3: Production Runtime (PHP 8.4 FPM Alpine)
# ==============================================================================
FROM php:8.4-fpm-alpine AS production

LABEL maintainer="URBANCOFF DevOps <devops@urbancoff.com>"
LABEL description="Production Docker image for URBANCOFF Laravel eCommerce Application on PHP 8.4"

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

# Install required PHP 8.4 extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
        pdo \
        pdo_sqlite \
        pdo_mysql \
        pdo_pgsql \
        bcmath \
        ctype \
        exif \
        fileinfo \
        gd \
        intl \
        mbstring \
        opcache \
        tokenizer \
        xml \
        zip

# Copy PHP and Nginx configuration
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/nginx.conf /etc/nginx/nginx.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application source code
COPY --chown=www-data:www-data . /var/www/html

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
