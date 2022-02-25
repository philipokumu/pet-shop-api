FROM php:8.0-fpm-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY .env.docker .env

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
