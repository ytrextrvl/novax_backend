FROM php:8.3-cli

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo_pgsql intl zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

RUN chmod +x /var/www/start.sh

EXPOSE 10000

CMD ["/var/www/start.sh"]
