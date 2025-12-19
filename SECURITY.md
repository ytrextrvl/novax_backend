
# SECURITY – NOVAX API

> سياسات الأمان لـ NOVAX Backend API

---

## 🚫 سياسة عدم الأسرار (No-Secrets Policy)

### ممنوع منعاً باتاً:
- ❌ رفع ملفات `.env` الحقيقية للمستودع
- ❌ كتابة كلمات مرور أو tokens في الكود
- ❌ رفع مفاتيح API أو connection strings
- ❌ رفع ملفات `.pem` أو `.key` أو service accounts

### مسموح:
- ✅ ملف `.env.example` بقيم وهمية
- ✅ الأسرار في Render Environment Variables
- ✅ الأسرار في GitHub Secrets

---

## 📋 سجل الحوادث (Incident Log)

| التاريخ | الحادثة | الإجراء | الحالة |
|---------|---------|---------|--------|
| 2025-12-19 | فحص أولي Phase 2 | لا أسرار مكشوفة | ✅ مغلق |

---

This document outlines all security features and best practices used in the NOVAX backend API.

---

## 🔐 Authentication

- Laravel 10 + JWT
- `jwt-auth` package handles access/refresh tokens
- Token expires after configurable TTL
- Device fingerprinting (optional)

---

## 🔐 Multi-Factor Authentication (MFA)

- MFA enforced for:
  - Admin roles
  - Finance managers
  - Pricing operations
- OTP via email / TOTP apps
- Toggle per user in admin

---

## 🔐 Role-Based Access Control (RBAC)

- Powered by `spatie/laravel-permission`
- Role hierarchy:
  - Super Admin
  - Admin
  - Finance Manager
  - Travel Agent
  - Customer
- Permission-based route protection
- MFA required for sensitive actions

---

## 🔒 Passwords & Hashing

- Hashed via `bcrypt`
- No plain passwords stored
- Password reset via secure token

---

## 🛡️ API Protection

- Rate limiting per IP
- Brute-force protection
- Global `ForceJsonResponse` and `SecurityHeaders` middleware
- Verified signed URLs for private file access

---

## 🔐 Encryption

- AES-256 for sensitive fields (passport, ID numbers)
- JWT tokens signed
- Encrypted storage via Backblaze signed URLs

---

## 🧾 Audit Logs

- Actions are logged to `activity_log`
- Includes:
  - Logins, Role changes
  - Request state transitions
  - Payment verification
  - File uploads

---

## 🚨 Intrusion Detection (Planned)

- Log suspicious activity
- Alert Admin on repeated failures or unusual behavior
