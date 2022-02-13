#!/bin/bash
php artisan migrate --force
php artisan config:cache
service nginx start
php-fpm