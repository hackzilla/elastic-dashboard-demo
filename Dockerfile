FROM php:7-apache

COPY ./opt/apache/site.conf /etc/apache2/sites-enabled/000-default.conf

VOLUME ["/var/www/html"]
ONBUILD COPY ./code /var/www/html

WORKDIR /var/www/html/web
