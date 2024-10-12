FROM php:8.2-apache
EXPOSE 80
RUN apt update && docker-php-ext-install pdo_mysql
CMD ["apachectl", "-D", "FOREGROUND"]
