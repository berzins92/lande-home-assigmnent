#!/bin/bash

echo "Installing composer dependencies"
docker exec -it lande-app composer install

# Run Laravel Artisan commands inside the container
echo "Running Artisan commands inside the container..."

# Execute Artisan commands using Docker exec
docker exec -it lande-app php artisan migrate --force
docker exec -it lande-app php artisan key:generate

docker-compose down
docker-compose up -d

docker exec -it lande-app php artisan config:clear
docker exec -it lande-app php artisan optimize

echo "Post-installation setup complete and Artisan commands executed!"

echo "Running swagger api documentation"
docker-compose exec lande-app php artisan l5-swagger:generate
