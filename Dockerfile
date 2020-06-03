FROM php:7.2-cli

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update

RUN pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug

RUN apt-get install -y git zip unzip

WORKDIR /app


COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./ /app

RUN composer install --no-interaction