#!/bin/sh

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

cd /var/www/html

echo "Config app..."

if [ "$role" = "app" ]; then
    mkdir -p bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R ug+rwx storage bootstrap/cache

    if [ "$env" = "production" ]; then
        echo "Caching configuration..."
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
    else
        composer update
        echo "Clear Caching..."
        php artisan cache:clear
        php artisan config:clear
        php artisan route:clear
    fi

else
    echo "Could not match the container role \"$role\""
    exit 1
fi


exec "$@"
