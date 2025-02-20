FROM php:8.2-apache

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
RUN apt update
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt install -y locales-all
RUN apt-get update \
    && apt-get install -y default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html