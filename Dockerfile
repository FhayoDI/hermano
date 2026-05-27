FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

COPY apache/stockfacil.conf /etc/apache2/sites-available/stockfacil.conf
RUN a2dissite 000-default.conf && a2ensite stockfacil.conf
