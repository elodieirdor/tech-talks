# Tech talks

## Installation

Create a copy of the .env.example 

``
cp .env.example .env 
``

Update the values of the new .env file if needed

Create a copy of the src/.env.example 

``
cp src/.env.example src/.env
``

Update the values of the new .env file if needed


Run docker 

``docker-compose up -d --build``

Create the database schema

``docker-compose run --rm artisan migrate``

Add some fake data

``docker-compose run --rm artisan db:seed``

Install the npm dependencies

``docker-compose run --rm npm install``

Run npm

``docker-compose run --rm npm run dev``


## Environment URLs

App : http://localhost:8088/

phpMyAdmin : http://localhost:8080/ 

## Run commands

composer : ``docker-compose run --rm composer COMPOSER_COMMAND``

npm : ``docker-compose run --rm npm NPM_COMMAND``

artisan : ``docker-compose run --rm artisan ARTISAN_COMMAND``