# NOVAX API Documentation

> **آخر تحديث:** 2025-12-20

---

## الملفات

| الملف | الوصف |
|-------|-------|
| `openapi.yaml` | OpenAPI 3.0 specification |

---

## كيفية التحديث

1. عدّل `openapi.yaml` مباشرة
2. تحقق من الصحة:
   ```bash
   npx @redocly/cli lint docs/api/openapi.yaml
   ```
3. أنشئ PR للمراجعة

---

## عرض التوثيق

### محلياً:
```bash
npx @redocly/cli preview-docs docs/api/openapi.yaml
```

### أونلاين:
- Swagger UI: `/api/documentation` (إذا مفعل)
- Redoc: استخدم GitHub raw URL

---

## Endpoints الجاهزية

| Endpoint | الوصف |
|----------|-------|
| GET /health | فحص الحياة |
| GET /ready | فحص الجاهزية (DB) |
| GET /version | معلومات الإصدار |

---

> راجع `openapi.yaml` للتفاصيل الكاملة
