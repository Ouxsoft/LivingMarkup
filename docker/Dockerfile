# set environment variable, e.g. DEV, TEST, PROD
ARG ENV

# select os
FROM ubuntu:18.04

# install apps
RUN apt-get update
RUN apt-get -y upgrade
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install \
    apache2 php7.2 libapache2-mod-php7.2 php7.2-mysql php7.2-dom php7.2-json php7.2-gd php7.2-yaml libxml2 curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# enable apache2 mods
RUN a2enmod php7.2
RUN a2enmod rewrite

# update the PHP.ini file, enable <? ?> tags and quieten logging
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.2/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.2/apache2/php.ini

# manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# expose Apache.
EXPOSE 80

# copy repo into web directory
# instead we are mounting in docker command -v .:/var/www
# ADD . /var/www/
# RUN rm -rf /var/www/docker
# RUN rm /var/www/docker.sh

# update the default apache site with provided config
ADD /docker/apache2/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# by default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND
