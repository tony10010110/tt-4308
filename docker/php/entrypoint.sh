#!/bin/sh
set -e

cd /var/www/backend

# Copy .env if missing
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install dependencies if vendor missing
if [ ! -d vendor ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Generate app key if missing
php artisan key:generate --no-interaction --force 2>/dev/null || true

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Wait for MySQL
echo "Waiting for MySQL..."
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    sleep 2
done
echo "MySQL is ready."

# Run migrations and seeders
php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction

exec php-fpm
