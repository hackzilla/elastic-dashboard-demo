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
  && apt-get install -y php7.0-mysql mysql-client \
  && docker-php-ext-install pdo_mysql

RUN apt-get install -y sudo


#########################################################
#  Build PHP with pthreads
#  https://hub.docker.com/r/jdecool/php-pthreads/~/dockerfile/
#########################################################

# php -r "echo phpversion();"
ENV VERSION 7.1.1

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
	autoconf \
	build-essential \
	libssl-dev \
	libxml2-dev \
	wget

RUN wget -qO php-$VERSION.tar.bz2 http://fr2.php.net/get/php-$VERSION.tar.bz2/from/this/mirror \
	&& tar xjf php-$VERSION.tar.bz2 \
	&& cd php-$VERSION \
	&& ./configure \
		--disable-cgi \
		--enable-mbstring \
		--enable-maintainer-zts \
		--enable-zip \
		--with-libdir=/lib/x86_64-linux-gnu \
		--with-openssl \
	&& make \
	&& make install \
	&& cp php.ini-production /usr/local/lib/php.ini \
	&& cd .. \
	&& pecl config-set php_ini /usr/local/lib/php.ini \
	&& pear config-set php_ini /usr/local/lib/php.ini \
	&& pecl install pthreads

RUN rm php-$VERSION.tar.bz2 \
	&& rm -rf php-$VERSION \
	&& apt-get purge -y autoconf build-essential wget .+-dev \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#########################################################



VOLUME ["/var/www/html"]
ONBUILD COPY ./code /var/www/html

WORKDIR /var/www/html/web

COPY ./opt/startup.sh /opt/startup.sh

CMD ["/opt/startup.sh"]
