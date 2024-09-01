# php/Dockerfile

FROM php:8.1-cli

WORKDIR /var/www/html

COPY ../Public /var/www/html

CMD [ "php", "-S", "0.0.0.0:8000", "-t", "/var/www/html" ]