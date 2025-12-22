# 💊 PharmStock (Manajemen Obat)

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)
![License](https://img.shields.io/github/license/fadlintauzy/manajemen_obat?style=for-the-badge)

**PharmStock** adalah solusi manajemen inventaris farmasi modern yang dirancang untuk efisiensi tinggi. Dibangun di atas fondasi **Laravel** yang kokoh, aplikasi ini menghadirkan sistem pelacakan stok yang presisi dengan metode **FEFO (First Expired, First Out)**, memastikan keamanan pasien dan optimalisasi aset obat.

Ditenagai oleh arsitektur Monolitik yang terpadu, PharmStock menggabungkan performa backend PHP dengan antarmuka responsif berbasis Blade dan Tailwind CSS.

## ✨ Highlights

* **Core Engine Terbaru:** Ditenagai oleh **Laravel** (Bleeding Edge) dan **PHP 8.2+**, menjamin performa, keamanan, dan *maintainability* jangka panjang.
* **Smart Inventory (FEFO):** Algoritma cerdas yang memprioritaskan distribusi obat berdasarkan tanggal kedaluwarsa terdekat untuk meminimalisir limbah medis.
* **Modern Frontend Tooling:** Asset bundling super cepat menggunakan **Vite** dan styling modern dengan **Tailwind CSS**.
* **Secure Authentication:** Sistem otentikasi dan manajemen sesi yang aman untuk apoteker dan administrator.
* **Responsive Dashboard:** Antarmuka intuitif yang dibangun dengan komponen Blade yang *reusable* dan desain adaptif untuk berbagai perangkat.

## 🛠️ Tech Stack

* **Backend:** Laravel Framework, PHP, MySQL/MariaDB.
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js, Vite.
* **Tooling & DX:** Composer, NPM/PNPM, Artisan CLI, Git.

## 📂 Repository Layout

Struktur direktori mengikuti standar modern Laravel untuk kemudahan navigasi dan skalabilitas.

```text
.
├── app/                    # Core logic (Models, Controllers, Services)
├── bootstrap/              # Framework bootstrapping
├── config/                 # Application configuration
├── database/               # Migrations, Seeders, Factories
├── public/                 # Entry point & compiled assets
├── resources/
│   ├── css/                # Tailwind CSS entry points
│   ├── js/                 # JavaScript scripts
│   └── views/              # Blade templates (Pages & Components)
├── routes/                 # Web & API route definitions
├── storage/                # Logs, compiled templates, uploads
├── tests/                  # Feature & Unit tests
├── vite.config.js          # Vite configuration
```

🚀 Getting Started
Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal (Local Development).

Prerequisites
PHP 8.2+ (Pastikan ekstensi seperti bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml aktif).

Composer (Dependency manager untuk PHP).

Node.js & NPM (atau PNPM).

MySQL atau database kompatibel lainnya.

1. Install Dependencies
Clone repositori dan install dependensi backend serta frontend.


```text
# Install Backend Dependencies
composer install


# Install Frontend Dependencies
npm install
```
2. Configure Environment
Salin file contoh konfigurasi dan sesuaikan dengan credential database lokal kamu.

```text
cp .env.example .env
```
Buka file .env dan atur konfigurasi database:

```text
APP_NAME=PharmStock
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manajemen_obat
DB_USERNAME=root
DB_PASSWORD=
```
3. Generate Key & Setup Database
Generate application key dan jalankan migrasi database (serta seeder jika tersedia).

```text
# Generate App Key
php artisan key:generate

# Run Migrations & Seeders
php artisan migrate --seed
```
4. Run the Application
Jalankan server pengembangan Laravel dan Vite secara bersamaan (kamu mungkin perlu dua terminal terpisah).

```text
# Terminal 1: Menjalankan Laravel Server
php artisan serve

# Terminal 2: Menjalankan Vite (Hot Module Replacement)
npm run dev
```
Akses aplikasi melalui browser di http://localhost:8000.

🧰 Useful Commands
Berikut adalah perintah-perintah yang sering digunakan dalam pengembangan:

`php artisan migrate:fresh --seed – Reset` database total dan isi ulang dengan data dummy.


`npm run build` – Compile aset untuk mode produksi (minified CSS/JS).

`php artisan test` – Menjalankan suite pengujian (Unit & Feature tests).

`php artisan optimize:clear` – Membersihkan semua cache framework.
