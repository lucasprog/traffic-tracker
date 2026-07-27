#!/bin/sh

set -e

cd /var/www

if [ ! -d node_modules ] || [ -z "$(ls -A node_modules 2>/dev/null)" ]; then
    echo "Installing dependencies..."

    if [ -f package-lock.json ]; then
        npm ci
    else
        npm install
    fi
fi

exec "$@"