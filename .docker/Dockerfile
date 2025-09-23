FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libc-dev libmagickwand-dev libxml2-dev libcurl4-openssl-dev \
    libonig-dev unzip libzip-dev libpng-dev libjpeg-dev imagemagick supervisor \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql xml mbstring curl zip \
    && docker-php-ext-enable gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_current.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

# 👉 Chỉ copy source Laravel trong thư mục src
COPY src/ /var/www/html

# Copy custom php.ini
COPY .docker/conf/php.ini /usr/local/etc/php/

# Cài composer dependencies
RUN composer install --no-ansi --no-interaction --no-progress --no-scripts --optimize-autoloader

# Copy supervisor config
COPY .docker/conf/supervisor.conf /etc/supervisor/conf.d/

EXPOSE 9000

COPY .docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
