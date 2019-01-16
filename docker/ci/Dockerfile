FROM php:7.2-cli-alpine3.7

RUN apk update

RUN apk add git curl zlib-dev sqlite-dev openssh-client

RUN docker-php-ext-install zip json mbstring pdo_sqlite

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require "laravel/envoy=~1.0"
