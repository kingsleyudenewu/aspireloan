#!/bin/bash

echo "Installing application"
sudo composer install
sudo composer du

echo "creating .env variables"
sudo cp .env.example .env

echo "generating application key"
sudo php artisan key:generate

echo "creating migration"
sudo php artisan migrate

echo "creating seed for the loan app"
sudo php artisan db:seed

echo "starting app"
sudo php artisan serve --port=8000

echo "publisher and subscriber is running"
