FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

RUN apt-get update -y
RUN apt-get install libyaml-dev git zip -y
RUN pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml
RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl  \
    && docker-php-ext-enable intl
RUN apt-get install -y sed
#RUN sed -i 's/short_open_tag = Off/short_open_tag: Off/g' /usr/local/etc/php/php.ini-development
#RUN sed -i 's/short_open_tag = On/short_open_tag: Off/g' /usr/local/etc/php/php.ini-production

RUN curl -sS https://getcomposer.org/installer | php -- \
        &&  mv composer.phar /usr/local/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

#RUN composer require annotations
#RUN composer require symfony/asset
#RUN composer require profiler --dev
#RUN composer require orm -W
#RUN composer require symfony/maker-bundle --dev
