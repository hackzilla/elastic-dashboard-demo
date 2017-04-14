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



##########################################################
##  Build PHP with pthreads
##  https://hub.docker.com/r/jdecool/php-pthreads/~/dockerfile/
##########################################################
#
## php -r "echo phpversion();"
#ENV VERSION 7.1.1
#
#RUN apt-get update && apt-get upgrade -y && apt-get install -y \
#	autoconf \
#	build-essential \
#	libssl-dev \
#	libxml2-dev
#
#RUN curl -s "http://fr2.php.net/get/php-$VERSION.tar.bz2/from/this/mirror" > php-$VERSION.tar.bz2 \
#	&& tar xjf php-$VERSION.tar.bz2 \
#	&& cd php-$VERSION \
#	&& ./configure \
#		--disable-cgi \
#		--enable-mbstring \
#		--enable-maintainer-zts \
#		--enable-zip \
#		--with-libdir=/lib/x86_64-linux-gnu \
#		--with-openssl \
#	&& make \
#	&& make install \
#	&& cp php.ini-production /usr/local/lib/php.ini \
#	&& cd .. \
#	&& pecl config-set php_ini /usr/local/lib/php.ini \
#	&& pear config-set php_ini /usr/local/lib/php.ini \
#	&& pecl install pthreads
#
#RUN rm php-$VERSION.tar.bz2 \
#	&& rm -rf php-$VERSION \
#	&& apt-get purge -y autoconf build-essential .+-dev \
#	&& apt-get clean \
#	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#########################################################


VOLUME ["/var/www/html"]
ONBUILD COPY ./code /var/www/html

WORKDIR /var/www/html/web

COPY ./opt/startup.sh /opt/startup.sh

CMD ["/opt/startup.sh"]
