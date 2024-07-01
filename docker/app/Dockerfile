FROM node:latest AS node
FROM php:8.0-fpm

EXPOSE 5173

ENV TZ Asia/Tokyo

# prepare npm
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# install Library
RUN apt-get update && \
	apt-get install -y git unzip libzip-dev libicu-dev libonig-dev libpq-dev \
  libfreetype6-dev libjpeg62-turbo-dev libpng-dev libjpeg-dev libnss3

RUN docker-php-ext-install intl pdo_mysql zip bcmath gd

RUN docker-php-ext-configure gd --enable-gd --with-jpeg

# config file COPY
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

# install Composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

WORKDIR /app
