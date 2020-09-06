# Tech talks

## Installation

### Create parameters for the environment
Create a copy of the .env.example and update it if needed

``
cp .env.example .env 
``

Create a copy of the src/.env.example and update it if needed

``
cp src/.env.example src/.env
``

### Run the environment

Run docker 

``docker-compose up -d --build``

Install the dependencies

``docker-compose run --rm composer install``

``docker-compose run --rm npm install``

Create the database schema

``docker-compose run --rm artisan migrate``

Add some fake data

``docker-compose run --rm artisan db:seed``

Generate keys for the app

``docker-compose run --rm artisan key:generate``

``docker-compose run --rm artisan passport:install``


Run the app

``docker-compose run --rm npm run dev``

## Environment URLs

App : http://localhost:8088/

phpMyAdmin : http://localhost:8080/ 

Swagger documentation : http://localhost:8088/api/documentation

## Tests

``docker-compose run --rm artisan test``

## Run commands

composer : ``docker-compose run --rm composer COMPOSER_COMMAND``

npm : ``docker-compose run --rm npm NPM_COMMAND``

artisan : ``docker-compose run --rm artisan ARTISAN_COMMAND``

## TODO

[Some improvements can be done](TODO.md)