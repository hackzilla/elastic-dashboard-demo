FROM php:7-apache

COPY ./opt/apache/site.conf /etc/apache2/sites-enabled/000-default.conf

# http://stackoverflow.com/questions/35500341/how-to-configure-php-7-apache-with-mysql-pdo-driver-in-debian-docker-image
RUN apt-get update \
  && apt-get install -y apt-transport-https lsb-release ca-certificates sudo \
  && echo 'deb https://packages.sury.org/php/ jessie main' >> /etc/apt/sources.list \
  && curl -s "https://packages.sury.org/php/apt.gpg" > /etc/apt/trusted.gpg.d/php.gpg \
  && apt-get update \
  && apt-get install -y mysql-client libicu-dev libxml2-dev \
  && docker-php-ext-install pdo_mysql intl simplexml opcache

VOLUME ["/var/www/html"]
ONBUILD COPY ./code /var/www/html

WORKDIR /var/www/html/web

COPY ./opt/startup.sh /opt/startup.sh

CMD ["/opt/startup.sh"]
