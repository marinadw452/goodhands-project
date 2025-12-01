# استخدم صورة PHP الرسمية مع Apache
FROM php:8.2-apache

# ثبّت الامتدادات الضرورية لـ PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# انسخ كل ملفات المشروع
COPY . /var/www/html/

# أعطِ صلاحيات صحيحة للمجلد
RUN chown -R www-data:www-data /var/www/html

# غير منفذ Apache إلى 8080 (متطلب Railway)
EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# شغّل ملف migrations قبل Apache تلقائيًا 
CMD php /var/www/html/run_migrations.php && apache2-foreground
