FROM php:8.2-cli

# تثبيت mysqli و pdo_mysql
RUN docker-php-ext-install mysqli pdo_mysql

# نسخ الملفات
COPY . /app
WORKDIR /app

# صلاحيات
RUN chown -R www-data:www-data /app && chmod -R 755 /app

# تشغيل السيرفر مع shell لتوسيع المتغير
CMD sh -c "php -S 0.0.0.0:${PORT:-8080} -t /app"
