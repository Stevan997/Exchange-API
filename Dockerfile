FROM ubuntu:20.04

#Avoid any terminal interaction
ARG DEBIAN_FRONTEND=noninteractive

# Install common tools
RUN apt-get update --fix-missing
RUN apt-get install -y wget curl nano htop git unzip zip bzip2 software-properties-common locales cron

# Set evn var to enable xterm terminal
ENV TERM=xterm


# Set working directory
WORKDIR /var/www/html

# Install PHP
RUN apt-get update --fix-missing
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt-get install -y \
    php7.4-fpm \
    php7.4-common \
    php7.4-curl \
    php7.4-mysql \
    php7.4-mbstring \
    php7.4-json \
    php7.4-xml \
    php7.4-zip \
    php7.4-gd \
    sqlite3 \
    php7.4-sqlite3 \
    php7.4-bcmath

ADD resources/www.conf /etc/php/7.4/fpm/pool.d/www.conf

# Install Nginx
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
RUN echo "deb http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN echo "deb-src http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN apt-get update

RUN apt-get install -y nginx

ADD resources/default /etc/nginx/sites-enabled/
ADD resources/nginx.conf /etc/nginx/

#Added php.ini file to support max upload file and max post file size
ADD resources/php.ini /etc/php/7.4/fpm/

RUN apt-get update --fix-missing
RUN apt-get install -y apache2

#------------- Composer & laravel configuration -----------------------------------------------

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#------------- Supervisor Process Manager -----------------------------------------------------

# Install supervisor
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor
ADD resources/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

#------------- Container Config ---------------------------------------------------------------

# Expose port 80
EXPOSE 80
RUN useradd nginx
# Set supervisor to manage container processes
ENTRYPOINT ["/usr/bin/supervisord"]

USER root
RUN chown www-data:www-data /var/www/html/

RUN (crontab -l ; echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1") | crontab -
