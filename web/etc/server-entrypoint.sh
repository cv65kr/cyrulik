#!/bin/sh

/usr/local/sbin/php-fpm -D

/usr/sbin/nginx -g 'daemon off;'
