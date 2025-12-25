FROM php:8.4

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-install zip pdo pdo_mysql mbstring xml curl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

RUN chmod +x /var/www/start.sh

CMD ["/var/www/start.sh"]

# --- Postgres (Neon) driver for PHP ---
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
 && docker-php-ext-install pdo_pgsql pgsql \
 && rm -rf /var/lib/apt/lists/*
