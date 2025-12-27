#!/usr/bin/env sh
set -e

# Render provides $PORT
PORT="${PORT:-10000}"


### NOVAX_RUNTIME_STORAGE_FIX ###
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache || true
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true
### NOVAX_RUNTIME_STORAGE_FIX ###

php artisan config:clear || true
php artisan route:clear || true

# Migrate + seed in production
php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host 0.0.0.0 --port "$PORT"
