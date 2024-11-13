FROM php:7.1-apache

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
RUN apt update
RUN apt install -y locales-all
RUN apt-get update \
    && apt-get install -y default-mysql-client \
    && rm -rf /var/lib/apt/lists/*