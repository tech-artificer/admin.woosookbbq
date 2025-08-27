#!/bin/bash

# Copy environment file
cp /home/u123456789/domains/yourdomain.com/.env.production .env

# Install composer dependencies without scripts first
composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# Now run the scripts after .env is in place
composer run-script post-autoload-dump

# Laravel setup
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force