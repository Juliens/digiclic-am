FROM php
RUN apt-get update && apt-get install -y libssl-dev git
WORKDIR /root/symfony
COPY ./config /usr/local/etc/php/conf.d
COPY ./front /root/symfony
RUN chmod 777 -R /root/symfony && rm -rf /root/symfony/app/cache/* 
EXPOSE 80

ENTRYPOINT php /root/symfony/app/console server:run 0.0.0.0:80
