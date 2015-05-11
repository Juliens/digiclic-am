FROM php
RUN apt-get update && apt-get install -y libssl-dev git \
    && docker-php-ext-install mbstring bcmath sockets \
    && pecl install mongo
WORKDIR /root/app
COPY ./config /usr/local/etc/php/conf.d
COPY ./app /root/app
RUN curl -sS https://getcomposer.org/installer | php && ./composer.phar install --prefer-dist --optimize-autoloader
EXPOSE 80

ENTRYPOINT php -S 0.0.0.0:80 -t /root/app
