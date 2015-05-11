FROM php
WORKDIR /root/symfony
COPY ./config /usr/local/etc/php/conf.d
COPY ./front /root/symfony
RUN chmod 777 -R /root/symfony && rm -rf /root/symfony/app/cache/* && curl -sS https://getcomposer.org/installer | php && ./composer.phar install --prefer-dist --optimize-autoloader
EXPOSE 80

ENTRYPOINT php /root/symfony/app/console server:run 0.0.0.0:80
