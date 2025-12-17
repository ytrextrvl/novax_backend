#!/usr/bin/env sh
set -e

# Render provides $PORT
PORT="${PORT:-10000}"

php artisan config:clear || true
php artisan route:clear || true

# Migrate + seed in production
php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host 0.0.0.0 --port "$PORT"
