# NOVAX Travel Backend API

> واجهة برمجة التطبيقات الخلفية لمنصة NOVAX TRAVEL

---

## ما هو هذا المشروع؟

هذا هو الـ Backend API لمنصة NOVAX TRAVEL، مبني باستخدام Laravel 10 مع PostgreSQL.

يوفر:
- إدارة المستخدمين والمصادقة (JWT + MFA)
- إدارة الرحلات والحجوزات
- إدارة الأسعار والعمولات
- إدارة الوكالات والمحافظ
- سجلات النشاط والتدقيق
- بيانات اليمن (شركات الطيران، المدن، المحافظات)

---

## التقنيات

| التقنية | الإصدار |
|---------|---------|
| PHP | 8.2 |
| Laravel | 10.x |
| PostgreSQL | 15+ (Neon) |
| JWT Auth | tymon/jwt-auth 2.0 |

---

## خطوات التحقق (للمالك غير التقني)

### 1. التحقق من أن الخدمة تعمل:
```
افتح في المتصفح: https://api.novaxtravel.com/api/health
يجب أن ترى: {"ok": true}
```

### 2. التحقق من لوحة Render:
```
1. ادخل إلى dashboard.render.com
2. ابحث عن خدمة novax-backend
3. تأكد أن Status = "Live"
```

### 3. التحقق من قاعدة البيانات:
```
1. ادخل إلى console.neon.tech
2. تأكد أن قاعدة البيانات novax متصلة
```

---

## الإعداد المحلي

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate --force
php artisan db:seed --force
php artisan serve
```

---

## النشر (Render - Docker)

- Render يجب أن يحتوي على متغيرات البيئة في Dashboard (لا تُرفع الأسرار للكود)
- Build: Docker
- Start command: `./start.sh`

---

## API Endpoints الرئيسية

| المسار | الوظيفة |
|--------|---------|
| `/api/health` | فحص صحة الخدمة |
| `/api/auth/*` | المصادقة (register/login/logout/refresh) |
| `/api/admin/auth/login` | تسجيل دخول الإدارة |
| `/api/flights/*` | إدارة الرحلات |
| `/api/requests/*` | إدارة الطلبات |
| `/api/pricing/*` | إدارة الأسعار |
| `/api/agencies/*` | إدارة الوكالات |
| `/api/wallet/*` | إدارة المحافظ |
| `/api/admin/*` | واجهات الإدارة |

---

## الملفات المهمة

| الملف | الغرض |
|-------|-------|
| [DEPLOYMENT.md](./DEPLOYMENT.md) | خطوات النشر |
| [ENV_VARIABLES_REFERENCE.md](./ENV_VARIABLES_REFERENCE.md) | متغيرات البيئة |
| [ROLLBACK.md](./ROLLBACK.md) | خطوات التراجع |
| [SECURITY.md](./SECURITY.md) | سياسات الأمان |
| [ADMIN_OPERATIONS_GUIDE.md](./ADMIN_OPERATIONS_GUIDE.md) | دليل العمليات |
| [CHECKLIST.md](./CHECKLIST.md) | قائمة المهام |

---

## ملاحظات أمنية مهمة

- **قم بتدوير أي أسرار** تم عرضها في لقطات شاشة أو مشاركتها
- اجعل `APP_DEBUG=false` في الإنتاج
- اضبط `CORS_ALLOWED_ORIGINS` بشكل صارم

---

> **آخر تحديث:** 2025-12-19
