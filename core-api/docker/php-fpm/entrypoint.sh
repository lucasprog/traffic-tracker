#!/bin/sh
set -e

echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-interaction --no-progress --prefer-dist

exec "$@"
