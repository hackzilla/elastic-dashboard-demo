FROM php:7-apache

COPY ./opt/apache/site.conf /etc/apache2/sites-enabled/000-default.conf

# http://stackoverflow.com/questions/35500341/how-to-configure-php-7-apache-with-mysql-pdo-driver-in-debian-docker-image
RUN apt-get update \
  && echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
  && echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
  && apt-get install -y wget \
  && wget https://www.dotdeb.org/dotdeb.gpg \
  && apt-key add dotdeb.gpg \
  && apt-get update \
  && apt-get install -y php7.0-mysql \
  && docker-php-ext-install pdo_mysql

RUN apt-get install -y mysql-client

VOLUME ["/var/www/html"]
ONBUILD COPY ./code /var/www/html

WORKDIR /var/www/html/web
