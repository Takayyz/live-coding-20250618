#!/bin/bash

echo "Setting up Laravel Docker environment..."

# Copy environment file
cp .env.docker src/.env

# Build and start containers
docker compose up -d --build

# Wait for database to be ready
echo "Waiting for database to be ready..."
sleep 20

# Install dependencies
echo "Installing composer dependencies..."
docker compose exec app composer install

# Generate application key
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate

# Set proper permissions
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

echo "Laravel Docker environment is ready!"
echo "Access your application at: http://localhost:8000"
