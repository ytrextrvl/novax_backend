# NOVAX Backend - Security Baseline

> **آخر تحديث:** 2025-12-20

---

## نموذج المصادقة (Authentication Model)

### JWT Authentication
- **نوع التوكن:** JWT (JSON Web Token)
- **مدة الصلاحية:** 24 ساعة
- **التجديد:** عبر refresh token
- **التخزين:** HTTP-only cookies (مفضل) أو Authorization header

### OTP (التحقق الثنائي)
- **الحالة:** مخطط للتنفيذ
- **القنوات:** SMS / Email
- **مدة الصلاحية:** 5 دقائق

### Device Binding
- **الحالة:** مخطط للتنفيذ
- **الآلية:** ربط الجهاز بـ device_id فريد

---

## نموذج الصلاحيات (RBAC)

| الدور | الصلاحيات |
|-------|-----------|
| super_admin | كل الصلاحيات |
| admin | إدارة الوكالات والرحلات |
| agency | إدارة حجوزات الوكالة |
| user | الحجز والعرض فقط |

---

## التسجيل والمراقبة (Logging & Audit)

### ما يتم تسجيله:
- محاولات تسجيل الدخول (ناجحة/فاشلة)
- تغييرات الصلاحيات
- عمليات الحجز
- أخطاء النظام

### ما لا يتم تسجيله:
- كلمات المرور
- أرقام البطاقات
- البيانات الشخصية الحساسة

### مكان التخزين:
- Laravel Log (storage/logs/)
- سيتم إضافة: External logging service

---

## التحقق من المدخلات (Input Validation)

### القواعد:
- كل المدخلات تمر عبر Laravel Validation
- تنظيف HTML/XSS تلقائي
- حد أقصى لحجم الطلب: 10MB

### Rate Limiting:
- **الحالة:** مخطط للتنفيذ
- **الحدود المقترحة:**
  - Login: 5 محاولات / دقيقة
  - API: 100 طلب / دقيقة
  - Search: 30 طلب / دقيقة

---

## سياسة CORS

```php
'allowed_origins' => [
    'https://novaxtravel.com',
    'https://admin.novaxtravel.com',
],
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
'allowed_headers' => ['Content-Type', 'Authorization'],
'max_age' => 86400,
```

---

## إدارة الأسرار (Secrets Policy)

### القواعد:
- ✅ الأسرار في `.env` فقط (لا تُرفع لـ Git)
- ✅ `.env.example` بقيم وهمية
- ✅ GitHub Secrets للـ CI/CD
- ❌ ممنوع hardcode للأسرار

### دورة التدوير (Rotation):
- JWT Secret: كل 90 يوم
- Database Password: كل 180 يوم
- API Keys: عند الاشتباه

---

## خطة الاستجابة للحوادث

راجع: [novax-infra/security/incident-response.md](https://github.com/ytrextrvl/novax-infra)

---

## المخاطر المعروفة

| المخاطر | الخطورة | الحالة | التخفيف |
|---------|---------|--------|---------|
| Rate limiting غير مفعل | MEDIUM | مخطط | Phase 5 |
| OTP غير مفعل | MEDIUM | مخطط | Phase 5 |
| External logging غير موجود | LOW | مخطط | Phase 5 |

---

> **آخر تحديث:** 2025-12-20
