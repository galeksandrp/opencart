FROM php:7.2.0-apache-stretch
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev wget
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd zip mysqli
