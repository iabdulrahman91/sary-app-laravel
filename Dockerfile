FROM php:8-fpm

RUN apt-get update
RUN apt-get install -y -qq --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    zip \
    unzip 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
# RUN command

CMD php artisan serve --host=0.0.0.0 --port 80

