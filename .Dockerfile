# هذي الصورة الوحيدة اللي تشتغل 100% على Railway مع mysqli في 2025
FROM heroku/php:8.2

# تثبيت mysqli و pdo_mysql يدويًا (مضمون)
RUN docker-php-ext-install mysqli pdo_mysql

# نسخ الملفات
COPY . /app

# صلاحيات
RUN chown -R www-data:www-data /app

# تشغيل Apache على البورت اللي Railway يعطيه
CMD php -S 0.0.0.0:${PORT:-8080} -t /app
