FROM php:7.4-fpm-alpine

# install deps
RUN set -xe \
    && apk add --no-cache \
        ${PHPIZE_DEPS} \
        openssh \
        openssl \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libxml2-dev \
        libmemcached-dev \
        libressl-dev \
        pkgconfig \
        zlib-dev \
        cyrus-sasl-dev \
        openjdk7-jre \
        supervisor \
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && docker-php-ext-install \
        intl \
        pcntl \
        sockets \
        opcache \
        zip \
    && pecl install -f \
        mongodb \
        xdebug-2.9.3 \
        redis \
    && docker-php-ext-enable \
        mongodb \
        redis \
    && apk add --no-cache --virtual .imagick-runtime-deps \
    && apk del ${PHPIZE_DEPS} \
    && rm -rf /tmp/*

COPY ./php/php.ini ${PHP_INI_DIR}/conf.d/
COPY ./php/supervisor/* /etc/supervisor/conf.d/
COPY ./php/supervisord.conf /etc/supervisor

COPY ./php/crontab /etc/cron.d/crontab
RUN chmod 0644 /etc/cron.d/crontab
RUN crontab /etc/cron.d/crontab

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
   && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
   && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
   && echo "xdebug.remote_log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini;

WORKDIR /var/www/app