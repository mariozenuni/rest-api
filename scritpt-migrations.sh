#!/bin/sh
echo "Running migrations..."
docker-compose exec app php artisan migrate --force
echo "Migrations completed!"
