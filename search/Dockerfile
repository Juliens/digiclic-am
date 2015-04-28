FROM php
RUN apt-get update && apt-get install -y libssl-dev git \
    && docker-php-ext-install mbstring bcmath sockets \
    && pecl install mongo
WORKDIR /root/symfony
COPY ./config /usr/local/etc/php/conf.d
COPY ./symfony /root/symfony
RUN curl -sS https://getcomposer.org/installer | php && ./composer.phar install --prefer-dist --optimize-autoloader
EXPOSE 80

ENTRYPOINT php /root/symfony/app/console server:run 0.0.0.0:80
