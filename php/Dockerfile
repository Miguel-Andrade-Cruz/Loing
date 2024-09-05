FROM php:8.1-cli

WORKDIR /var/www

COPY ./app ./app

COPY ./vendor ./vendor

CMD [ "php", "-S", "0.0.0.0:8000", "-t", "/var/www/app/Public" ]