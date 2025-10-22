# استخدم صورة PHP الرسمية مع Apache
FROM php:8.2-apache

# ثبّت الامتدادات الضرورية لـ PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# انسخ كل ملفات المشروع إلى مجلد السيرفر
COPY . /var/www/html/

# أعطِ صلاحيات صحيحة لمجلد المشروع
RUN chown -R www-data:www-data /var/www/html

# غير المنفذ الافتراضي إلى 8080 (لـ Railway)
EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# شغّل Apache
CMD ["apache2-foreground"]
