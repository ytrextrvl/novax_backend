
# ROLLBACK GUIDE – NOVAX API

This guide explains how to safely rollback the NOVAX API if an issue occurs in production.

---

## 🚨 When to Rollback

- Deployment failure
- Bug introduced in latest release
- Outage in Render/Neon
- Broken migration or seeder

---

## 🧰 Step-by-Step Rollback (Render)

### 1. Revert to Previous Git Commit

```bash
git log   # Copy commit hash of stable version
git checkout <commit>
git push origin main
```

### 2. Redeploy via Render

Render will auto-deploy the previous code snapshot.

---

## 🧰 Rollback Database Migration

If a migration causes issues:

```bash
php artisan migrate:rollback
```

For multiple steps:

```bash
php artisan migrate:rollback --step=2
```

---

## 🧼 Clear Cache (Optional)

```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

---

## 💾 Backup Strategy

- Database backups are enabled via Neon (PITR)
- Storage backups done via Backblaze B2 versioning
- Config snapshots should be exported regularly

---

## ✅ Restore from Backup (Neon)

1. Log into Neon
2. Use PITR restore to a new branch
3. Point Render to the restored DB

---

Always test updates in **staging** before deploying to production.
