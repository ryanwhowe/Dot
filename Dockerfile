FROM php:5.6-fpm-stretch

# since stretch is EOL we need to pull in the archive repos to update and install the packages
RUN echo "deb http://archive.debian.org/debian stretch main" > /etc/apt/sources.list

RUN apt-get update

RUN apt-get install -y --no-install-recommends \
    git \
    unzip \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    default-mysql-client \
  && docker-php-ext-install \
    zip \
    intl \
    mysqli \
    pdo pdo_mysql \
    opcache

# update the pecl protocols to the latest, the version that ships with the 5.6 container is outdated
RUN pecl channel-update pecl.php.net

RUN yes | pecl install xdebug-2.5.5 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# this is not availabel on php 5.6 put will be used on 7.0+
#RUN pecl install apcu && docker-php-ext-enable apcu \
#    && echo "apc.enable_cli=1" >> /usr/local/etc/php/php.ini \
#    && echo "apc.enable=1" >> /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_CACHE_DIR=/tmp

RUN mkdir --parents /tmp/logs

WORKDIR /var/www/