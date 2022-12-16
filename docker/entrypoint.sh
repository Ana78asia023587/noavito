#!/bin/bash

php artisan migrate --force
php artisan config:cache
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf