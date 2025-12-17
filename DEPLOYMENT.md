
# DEPLOYMENT GUIDE – NOVAX API (Laravel)

This document explains how to deploy the NOVAX backend to production using **Render**, **Neon DB**, **Cloudflare**, and **Backblaze**.

---

## ✅ 1. Prerequisites

You must have:

- Access to:
  - GitHub (project repo)
  - Render account (Owner)
  - Neon PostgreSQL account
  - Cloudflare account (for domain SSL + DNS)
  - Backblaze account (for file storage)

---

## 🚀 2. Deploy to Render

### A. Connect GitHub

1. Push this `novax-api` project to a **new GitHub repository**
2. Log into [Render.com](https://render.com)
3. Click "New Web Service"
4. Choose **GitHub repo** with `novax-api`
5. Use the following settings:

| Field | Value |
|-------|-------|
| Environment | **Docker** |
| Dockerfile Path | `Dockerfile` |
| Start Command | `./start.sh` |
| Branch | `main` |

### B. Environment Variables

Set the following env vars in Render:

- `APP_ENV=production`
- `APP_KEY=...` (generate with `php artisan key:generate`)
- `APP_DEBUG=false`
- `DB_CONNECTION=pgsql`
- `DB_HOST=...` (from Neon)
- `DB_PORT=5432`
- `DB_DATABASE=...`
- `DB_USERNAME=...`
- `DB_PASSWORD=...`
- `JWT_SECRET=...` (use `php artisan jwt:secret`)
- `FILESYSTEM_DISK=b2`
- `B2_KEY_ID=...` (from Backblaze)
- `B2_APPLICATION_KEY=...`
- `B2_BUCKET=...`

---

## 🧪 3. Test Health

After deployment, visit:

```
https://api.novaxtravel.com/health
```

It should return:

```
{
  "status": "OK"
}
```

---

## 🔐 4. SSL, DNS & Domain

Go to Cloudflare and:

- Add the domain `api.novaxtravel.com`
- Point A record to Render external IP
- Enable **Full (Strict)** SSL
- Add WAF & Bot Protection rules

---

## 🧩 5. Seed the Database

From Render Shell or locally:

```
php artisan migrate --seed
```

This will install:
- Yemen domain data
- Roles & permissions
- System defaults

---

✅ Done! NOVAX API is live.
