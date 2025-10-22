FROM dunglas/frankenphp

RUN install-php-extensions pdo_pgsql pgsql

COPY . /app
WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]
