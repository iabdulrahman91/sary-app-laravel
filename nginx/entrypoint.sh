#!/bin/bash
php artisan migrate
service nginx start
php-fpm