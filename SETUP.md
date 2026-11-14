# Setup (Laravel 12 + Filament 5)

Prasyarat: PHP 8.2+, Composer, MySQL atau SQLite.

```bash
composer create-project laravel/laravel jasa-desain
cd jasa-desain

# salin isi zip ini (app, database, resources, routes) ke dalam proyek, timpa jika ditanya
composer require filament/filament:"^5.0"
php artisan filament:install --panels      # id panel: admin

# atur database di .env (SQLite bawaan Laravel juga bisa)
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

- Website: http://localhost:8000
- Admin:   http://localhost:8000/admin  (admin@example.com / password)

Ganti password admin setelah login pertama.
