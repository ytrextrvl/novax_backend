# NOVAX Travel Backend (Laravel API)

This repository is a standalone backend for **NOVAX TRAVEL** based on the uploaded execution directive + the frontend codebases.

## What’s included
- PostgreSQL (Neon) support
- JWT authentication (`/api/auth/*`) + **compatibility** endpoint used by your admin UI: `/api/admin/auth/login`
- MFA endpoints baseline: `/api/auth/mfa/enable`, `/api/auth/mfa/verify`
- Baseline API catalog modules:
  - Flights: search/manual create/routes/ticket upload
  - Requests: create/view/state change/payment verify
  - Pricing: rules + apply
  - Agencies
  - Wallet & Loyalty
- Roles/permissions (admin/user) + audit logs
- Yemen dataset seeding (airlines, cities, governorates) extracted from the directive

## Local setup
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate --force
php artisan db:seed --force
php artisan serve
```

## Deploy (Render - Docker)
Render should set environment variables in the dashboard (never commit secrets).
Build: Docker
Start command: `./start.sh`

## Security notes (IMPORTANT)
- **Rotate any secrets** that were ever shown in screenshots or shared anywhere.
- Keep `APP_DEBUG=false` in production.
- Set strict `CORS_ALLOWED_ORIGINS`.

