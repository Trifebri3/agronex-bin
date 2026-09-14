# Production Dockerfile for Unified EcoSense Monitoring Hub
FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    sqlite

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy codebase
COPY . /var/www

# Configure permissions & environment
RUN cp .env.example .env \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && touch /var/www/database/database.sqlite \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database

# Expose port
EXPOSE 8000

# Start command
CMD php artisan key:generate --force && php artisan migrate --seed --force && php artisan serve --host=0.0.0.0 --port=8000
