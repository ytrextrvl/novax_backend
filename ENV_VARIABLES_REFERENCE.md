
# ENVIRONMENT VARIABLES REFERENCE – NOVAX API

This document provides a reference for all required `.env` and Render environment variables.

---

## 🔐 Application Config

| Variable | Example | Description |
|----------|---------|-------------|
| `APP_ENV` | `production` | Environment mode |
| `APP_KEY` | `base64:...` | Laravel encryption key |
| `APP_DEBUG` | `false` | Disable in production |

---

## 🗄️ Database (Neon PostgreSQL)

| Variable | Example |
|----------|---------|
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `ep-xyz.neon.tech` |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `novax` |
| `DB_USERNAME` | `novax_user` |
| `DB_PASSWORD` | `securepassword` |

---

## 🔑 JWT Authentication

| Variable | Description |
|----------|-------------|
| `JWT_SECRET` | Run `php artisan jwt:secret` to generate |

---

## ☁️ File Storage (Backblaze B2)

| Variable | Description |
|----------|-------------|
| `FILESYSTEM_DISK` | `b2` |
| `B2_KEY_ID` | From Backblaze app key |
| `B2_APPLICATION_KEY` | Secret from Backblaze |
| `B2_BUCKET` | Bucket name |

---

## 📧 Email / Notifications (Optional)

| Variable | Description |
|----------|-------------|
| `MAIL_MAILER` | smtp |
| `MAIL_HOST` | smtp.mailtrap.io / hostinger |
| `MAIL_PORT` | 587 |
| `MAIL_USERNAME` | Your SMTP username |
| `MAIL_PASSWORD` | Your SMTP password |
| `MAIL_FROM_ADDRESS` | `noreply@novaxtravel.com` |
| `MAIL_FROM_NAME` | `NOVAX Travel` |

---

## ✅ Optional (Advanced)

| Variable | Description |
|----------|-------------|
| `LOG_CHANNEL` | `stack` |
| `CACHE_DRIVER` | `file` or `redis` |
| `SESSION_DRIVER` | `file` or `database` |
