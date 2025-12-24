FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev libpq-dev \
  && docker-php-ext-install zip pdo pdo_pgsql mbstring xml curl opcache \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader \
  && chmod +x /var/www/start.sh

EXPOSE 10000
CMD ["/var/www/start.sh"]
