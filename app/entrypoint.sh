#!/bin/sh
php artisan migrate:fresh --seed && php artisan key:generate
php-fpm