# صورة PHP رسمية مع Apache (مضمونة على Railway)
FROM php:8.2-apache

# تثبيت امتدادات MySQL يدويًا
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo_mysql gd \
    && a2enmod rewrite

# نسخ الملفات
COPY . /var/www/html/

# صلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# تغيير البورت لـ Railway
ENV PORT=8080
RUN sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf \
    && echo "Listen $PORT" >> /etc/apache2/ports.conf

# تشغيل Apache
CMD ["apache2-foreground"]
