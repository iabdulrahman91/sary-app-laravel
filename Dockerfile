FROM composer:2 as build
WORKDIR /app
COPY . /app
RUN composer install --optimize-autoloader --no-dev

RUN cp .env.example .env
RUN php artisan key:generate

FROM php:8-fpm

RUN apt-get update -qq \
    && apt-get install -y nginx \
    && apt-get install -y -qq --no-install-recommends \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        calendar \
        gd \
        bcmath \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/

COPY --from=build /app /var/www/html/

COPY nginx/nginx-site.conf /etc/nginx/sites-enabled/default
COPY nginx/entrypoint.sh /etc/entrypoint.sh

RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache
RUN chmod +x /etc/entrypoint.sh


EXPOSE 80

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]