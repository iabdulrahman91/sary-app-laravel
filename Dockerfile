FROM composer:2 as build
WORKDIR /app
COPY . /app
RUN composer install --optimize-autoloader --no-dev



FROM php:8-fpm

RUN apt-get update -y
RUN apt-get install -y nginx 

COPY --from=build /app /var/www/html/

COPY nginx/nginx-site.conf /etc/nginx/sites-enabled/default
COPY nginx/entrypoint.sh /etc/entrypoint.sh

RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache
RUN chmod +x /etc/entrypoint.sh


EXPOSE 80

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]