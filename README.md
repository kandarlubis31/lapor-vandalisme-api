# lapor-vandalisme-api

REST API + panel admin untuk **laporan vandalisme** berbasis Laravel & Sanctum.

## Fitur Utama
- Registrasi & login (token Sanctum)
- CRUD laporan vandalisme (milik user masing-masing)
- Leaderboard pengguna aktif
- Validasi laporan oleh admin (pending → validate)
- Panel admin web (`/admin/login` + dashboard + manajemen users)

## Tech Stack
Laravel (REST API) · Sanctum · Blade (panel admin) · SQLite/MySQL

## Menjalankan
```bash
composer install
php artisan migrate --seed
php artisan serve
```

Lihat `CONTEXT.md` di folder ini untuk detail arsitektur.
