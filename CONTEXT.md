# lapor-vandalisme-api — Project Context

## Ringkasan
**REST API + panel admin** untuk pelaporan vandalisme. User bisa mendaftar, login (token Sanctum), melaporkan vandalisme beserta foto & koordinat lokasi, melihat/mengedit/menghapus laporannya sendiri, dan melihat leaderboard. Admin memvalidasi laporan (pending → valid/ditolak) dan memberikan **+10 poin** untuk laporan yang valid. Ada juga panel web admin (login terpisah) untuk dashboard & manajemen user.

## Tech Stack
- Laravel (REST API) + Sanctum
- Validasi manual pakai `Validator` / `validate()`
- Blade untuk panel admin web
- Storage `public` untuk media laporan

## Struktur Utama
```
app/
├── Http/Controllers/
│   ├── Api/
│   │   ├── AuthController.php                    # register, login, logout (token)
│   │   ├── ReportController.php                  # CRUD laporan milik user sendiri
│   │   ├── LeaderboardController.php             # top 10 user berdasarkan poin
│   │   └── Admin/ReportValidationController.php  # daftar pending + validasi (kasih poin)
│   └── Web/
│       ├── AdminLoginController.php              # login/logout admin web
│       ├── AdminDashboardController.php          # daftar laporan pending
│       └── Admin/UserController.php              # manajemen users (role, password)
├── Http/Middleware/AdminMiddleware.php           # cek role === 'admin' (API)
├── Models/
│   ├── User.php   # role (user/admin), points; relasi reports()
│   └── Report.php # user_id, title, description, media_url, category, lat/lng, status
routes/
├── api.php   # /register, /login (publik); reports CRUD + admin (auth:sanctum)
└── web.php   # /admin/login + /admin/dashboard + users (auth + admin)
```

## Skema Database
- **users**: name, email (unique), password, phone_number (unique, nullable), role enum(`user`,`admin`) default user, points (unsignedBigInteger, default 0)
- **reports**: user_id (FK cascade), title, description, media_url, category enum(`vandalisme`,`pembakaran`,`perusakan`,`lainnya`), latitude decimal(10,7), longitude decimal(10,7), status enum(`pending`,`valid`,`ditolak`) default pending

## API Endpoints
| Method | URI | Auth | Keterangan |
|--------|-----|------|------------|
| POST | `/api/register` | publik | name, email, password (min 8, confirmed) → token |
| POST | `/api/login` | publik | email, password → token |
| POST | `/api/logout` | sanctum | hapus currentAccessToken |
| GET | `/api/user` | sanctum | profil user aktif |
| GET | `/api/leaderboard` | sanctum | top 10 `role=user` by points |
| GET | `/api/reports` | sanctum | laporan milik user (paginate 10) |
| POST | `/api/reports` | sanctum | title, description, category, lat/lng, media (image ≤5MB) → 201 |
| GET | `/api/reports/{report}` | sanctum | owner-only (403 kalau bukan punya) |
| PUT/PATCH | `/api/reports/{report}` | sanctum | owner-only, update title/desc/category |
| DELETE | `/api/reports/{report}` | sanctum | owner-only, hapus file media + record |
| GET | `/api/admin/reports/pending` | sanctum+admin | list pending (paginate 15) |
| PATCH | `/api/admin/reports/{report}/validate` | sanctum+admin | status `valid`/`ditolak`; valid → +10 poin |

## Panel Web Admin
- `GET/POST /admin/login`, `POST /admin/logout` (session)
- `GET /admin/dashboard` → daftar laporan pending (eager load user)
- `resource users` → index/edit/update/destroy (proteksi: tidak bisa hapus akun sendiri)

## Rules Bisnis
| Rule | Implementasi |
|------|-------------|
| Hanya pemilik bisa akses/ubah/hapus laporan | `$request->user()->id !== $report->user_id` → 403 |
| Media wajib gambar ≤ 5MB | `required|image|mimes:jpeg,png,jpg,gif|max:5120` |
| Kategori terbatas | enum vandalisme/pembakaran/perusakan/lainnya |
| Laporan valid → +10 poin | `$reporter->points += 10` saat status jadi `valid` |
| Laporan yang sudah diproses tidak bisa divalidasi ulang | status !== pending → 409 |
| Admin API wajib role admin | `AdminMiddleware` → 403 |

## Catatan
- **Bahasa pesan campur**: beberapa pesan API masih Inggris (`Unauthorized`, `Report successfully deleted`), panel web campur Inggris/Indonesia.
- Upload media disimpan di `storage/app/public/reports_media` (disk public).
- Tidak ada pagination untuk leaderboard (hanya `take(10)`).

---
*Last updated: 2026-08-08 · Ditulis manual dari kode asli*
