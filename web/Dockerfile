FROM php:7.3.0-fpm-alpine3.8

# Install libraries
RUN apk update && apk upgrade && apk add --no-cache \
    --virtual .phpize-deps $PHPIZE_DEPS \
    build-base zlib-dev curl git openssl yarn npm nginx

RUN apk add --update tzdata && \
    cp /usr/share/zoneinfo/Europe/Warsaw /etc/localtime && \
    echo "Europe/Warsaw" >  /etc/timezone && \
    apk del tzdata

RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

RUN rm -rf /var/cache/apk/*

# Configuration files
COPY etc/docker/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY etc/docker/php.ini /usr/local/etc/php/php.ini
COPY etc/docker/nginx.conf /etc/nginx/nginx.conf

HEALTHCHECK CMD (curl -f -s "http://0.0.0.0/healthcheck" | grep "OK") || exit 1

COPY . /var/www
WORKDIR /var/www

# Create application
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-progress --no-interaction --no-suggest --optimize-autoloader --ansi

ARG env

RUN yarn install && npm rebuild node-sass && yarn encore $env

RUN chmod +x /var/www/etc/server-entrypoint.sh

VOLUME /var/www

EXPOSE 80

ENTRYPOINT ["sh", "etc/server-entrypoint.sh"]