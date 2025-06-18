FROM php:8.2-apache

RUN apt update

COPY /aplikacje_internetowe_zad3-master/ /var/www/html/htdocs/

