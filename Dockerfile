FROM php:7.4-fpm

USER root

WORKDIR /var/www

# Install dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends procps build-essential openssl nginx libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl git jpegoptim optipng pngquant gifsicle locales libonig-dev supervisor nano cron \
    && docker-php-ext-configure gd  \
    && docker-php-ext-install gd \
    && apt-get install -y --no-install-recommends libgmp-dev \
    && docker-php-ext-install gmp \
    && docker-php-ext-install pdo_mysql mbstring bcmath pcntl \
    && docker-php-ext-install pdo \
    && docker-php-ext-enable opcache \
    && docker-php-ext-install zip \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/pear/ \
    && curl -sL https://deb.nodesource.com/setup_12.x | bash \
    && apt-get install nodejs \
    && node -v \
    && npm -v

RUN apt-get install -y --no-install-recommends \
		imagemagick \
        libmagickwand-dev

RUN pecl install imagick; \
    docker-php-ext-enable imagick

# Install redis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Copy files
COPY . /var/www

COPY ./deploy/php/php.ini /usr/local/etc/php/php.ini

COPY ./deploy/php/php-pool /usr/local/etc/php-fpm.d

COPY ./.env.example /var/www/.env

COPY ./deploy/nginx/nginx.conf /etc/nginx/nginx.conf

COPY ./deploy/supervisor/conf.d /etc/supervisor/conf.d

# Set permissions
RUN chown -R www-data:www-data /var/www

RUN chgrp -R www-data /var/www

RUN chown -R www-data:www-data /var/www/storage

# Setup npm
RUN npm install --force

RUN npm rebuild node-sass

RUN npm run prod

# Setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --working-dir="/var/www"

RUN composer dump-autoload -o --working-dir="/var/www"

RUN php artisan config:clear

RUN php artisan config:cache

RUN php artisan event:cache

# RUN php artisan migrate --force

EXPOSE 8080

ENTRYPOINT ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]