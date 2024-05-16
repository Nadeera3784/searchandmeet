#!/bin/bash

cd /var/www

sudo mkdir -p bootstrap/cache

sudo npm install

sudo npm run prod

sudo chmod 755 /var/www//storage -R

sudo chown -R www-data:www-data  /var/www

sudo cp run.env .env

sudo php artisan optimize

sudo composer install

sudo service php7.4-fpm start

sudo service nginx start

sudo service supervisor start