#!/bin/sh
set -e

APP_ENV=${APP_ENV:-production}

echo "Starting container in $APP_ENV mode..."

# Permissions
mkdir -p bootstrap/cache storage
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    echo "Dev mode: clearing cache..."
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
fi

exec "$@"
