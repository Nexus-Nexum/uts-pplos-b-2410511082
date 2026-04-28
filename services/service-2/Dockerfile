FROM php:8.1-apache

RUN a2enmod rewrite

COPY . /var/www/html/

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80