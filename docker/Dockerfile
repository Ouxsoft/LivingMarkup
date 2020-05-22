FROM ubuntu:18.04
LABEL maintainer="ouxsoft <noreply@example.com>"

# environment variables
# (can be changed on docker run with -e)

# system
ENV TIMEZONE Etc/UTC
ENV DEBIAN_FRONTEND noninteractive

# apache
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_SERVER_ADMIN admin@localhost
ENV APACHE_SERVER_NAME localhost
ENV APACHE_SERVER_ALIAS docker.localhost
ENV APACHE_DOCUMENT_ROOT /var/www/html
ENV APACHE_WORKER_START_SERVERS 2
ENV APACHE_WORKER_MIN_SPARE_THREADS 2
ENV APACHE_WORKER_MAX_SPARE_THREADS 10
ENV APACHE_WORKER_THREAD_LIMIT 64
ENV APACHE_WORKER_THREADS_PER_CHILD 25
ENV APACHE_WORKER_MAX_REQUEST_WORKERS 4
ENV APACHE_WORKER_MAX_CONNECTIONS_PER_CHILD 0

# locale specific
ENV LANGUAGE en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8

# install apps
RUN apt-get update \
    && apt-get install -y \
    apache2 \
    php7.2 \
    libapache2-mod-php7.2 \
    php7.2-mysql \
    php7.2-dom \
    php7.2-json \
    php7.2-gd \
    php7.2-yaml \
    libxml2 curl

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# enable apache2 mods
RUN a2enmod php7.2
RUN a2enmod rewrite

# update the PHP.ini file, enable <? ?> tags and quieten logging
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.2/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.2/apache2/php.ini

# expose Apache.
EXPOSE 80

# copy repo into web directory
# instead we are mounting in docker command -v .:/var/www
# ADD . /var/www/
# RUN rm -rf /var/www/docker
# RUN rm /var/www/docker.sh

# update the default apache site with provided config
ADD apache2/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# by default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND
