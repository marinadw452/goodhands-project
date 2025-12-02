FROM php:8.2-apache

# تثبيت MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# نسخ الملفات
COPY . /var/www/html/

# صلاحيات
RUN chown -R www-data:www-data /var/www/html

# تغيير بورت Apache لـ Railway
ENV PORT=8080
RUN sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
RUN echo "Listen $PORT" > /etc/apache2/ports.conf

CMD ["apache2-foreground"]
