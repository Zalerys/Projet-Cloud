FROM php:8.2-fpm-alpine3.17

RUN apk update \
    && apk --no-cache add $PHPIZE_DEPS openssl-dev nginx bash git nano icu-dev libzip-dev apk-cron libxml2-dev oniguruma-dev libpng-dev libxslt-dev \
    &&  curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer \
    &&  curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    &&  apk add symfony-cli
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql opcache intl zip calendar dom mbstring gd xsl
RUN pecl install apcu && docker-php-ext-enable apcu
RUN docker-php-ext-install opcache

RUN apk add --no-cache supervisor

COPY ./supervisord/supervisord.conf /etc/supervisord.conf
COPY ./conf/site.conf /etc/nginx/http.d/default.conf

WORKDIR /var/www

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
