# -------------------------------
# 1. Base image
# -------------------------------
FROM php:8.2-fpm-alpine AS base

# Cài PHP extensions + Redis extension (tối ưu, xóa build deps sau khi build)
RUN apk add --no-cache \
        bash curl git unzip \
        icu-libs libzip \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS icu-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath intl opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# -------------------------------
# 2. Composer stage
# -------------------------------
FROM composer:2.7 AS vendor
WORKDIR /app
COPY src/composer.json src/composer.lock* ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --optimize-autoloader

# -------------------------------
# 3. Final app stage
# -------------------------------
FROM base AS app
WORKDIR /var/www/html

# Copy vendor từ stage trước
COPY --from=vendor /app/vendor ./vendor

# Copy toàn bộ source code
COPY src/ .

# PHP ini
COPY .docker/conf/php.ini /usr/local/etc/php/conf.d/custom.ini

# Chown chmod chuẩn
RUN mkdir -p bootstrap/cache storage \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwx storage bootstrap/cache

# Entrypoint script
COPY .docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

CMD ["php-fpm"]
ENTRYPOINT ["entrypoint.sh"]
