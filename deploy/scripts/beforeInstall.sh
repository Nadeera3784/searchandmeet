#!/bin/bash

sudo service php7.4-fpm stop

sudo service nginx stop

sudo service supervisor stop

sudo rm /var/www -Rf