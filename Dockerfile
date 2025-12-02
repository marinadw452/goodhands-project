FROM php:8.2-cli

# تثبيت امتدادات MySQL يدويًا (مضمون 100%)
RUN docker-php-ext-install mysqli pdo_mysql

# نسخ الملفات
COPY . /app
WORKDIR /app

# صلاحيات
RUN chown -R www-data:www-data /app && chmod -R 755 /app

# تشغيل السيرفر على البورت اللي Railway يحدده
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:${PORT:-8080}", "-t", "/app"]
