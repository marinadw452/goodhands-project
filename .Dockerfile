FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_pgsql pgsql

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]
