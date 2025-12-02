# استخدم صورة PHP رسمية مع Apache
FROM php:8.2-apache

# ثبّت امتداد MySQL (مش PostgreSQL)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# انسخ ملفات المشروع
COPY . /var/www/html/

# صلاحيات
RUN chown -R www-data:www-data /var/www/html

# غيّر بورت Apache إلى اللي Railway يحبه
ENV PORT=8080
RUN sed -i "s/80/${PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
RUN echo "Listen ${PORT}" >> /etc/apache2/ports.conf

# شغّل Apache
CMD ["apache2-foreground"]
