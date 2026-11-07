# lapor-vandalisme-api

A REST API and admin panel for reporting public-facility vandalism, built with Laravel and
Sanctum.

Citizens register, file reports with a location and description, and climb a leaderboard for
contributing. Admins review submissions and mark them valid or rejected.

## Features

- **Token authentication** — register and log in through Sanctum; the API is stateless.
- **Report CRUD** — each user manages their own reports only, enforced at the query level rather
 than by filtering in the controller response.
- **Leaderboard** — ranks users by reporting activity.
- **Admin validation** — pending reports move to validated once an admin reviews them.
- **Web admin panel** — separate login at `/admin/login`, dashboard, and user management, behind
 `AdminMiddleware`.
- **Ownership model** — `User` → `Report`, so a report always has a reporter.

## Stack

Laravel · Sanctum · Eloquent · Blade (admin panel) · SQLite or MySQL

## Structure

```
app/
  Http/Controllers/Api/
    AuthController.php                 register / login / logout
    ReportController.php               user-owned report CRUD
    LeaderboardController.php          ranking
    Admin/ReportValidationController.php  moderation actions
  Http/Controllers/Web/Admin/          dashboard, admin login, user management
  Http/Middleware/AdminMiddleware.php  admin-only guard
  Models/Report.php, Models/User.php
routes/                                api.php + web.php
```

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

`config/database.php` defaults to SQLite, which needs no server; switch `DB_CONNECTION` to `mysql`
in `.env` for a real deployment. The admin panel is then reachable at `/admin/login`.

## Notes

- The seeder creates sample data for local use. Do not run it against production.
- Uploaded evidence images should live on object storage, not in the repository or on the app's
 local disk — Laravel's `filesystems.php` is the place to configure that.
- Reports contain user-submitted content and locations; treat the database as personal data.

---

## Bahasa Indonesia

**lapor-vandalisme-api** adalah REST API dan panel admin untuk melaporkan vandalisme fasilitas umum, dibangun dengan Laravel dan Sanctum.

Warga mendaftar, mengirim laporan berisi lokasi dan deskripsi, lalu naik peringkat lewat papan skor pelaporan.

---

## License

MIT
