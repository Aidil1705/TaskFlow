# TaskFlow

Aplikasi manajemen tugas sederhana berbasis PHP + MySQL dengan tampilan modern menggunakan Tailwind CSS (CDN).

## Ringkasan

TaskFlow membantu tim kecil mencatat, memantau, dan memperbarui status pekerjaan dalam satu dashboard sederhana.

Fitur utama yang saat ini tersedia:
- Login pengguna
- Registrasi pengguna
- Dashboard ringkasan jumlah tugas berdasarkan status
- Daftar tugas + filter status
- Detail tugas
- Edit tugas
- Tambah tugas (proses backend sudah ada)
- Logout

## Teknologi

- PHP (native, procedural)
- MySQL / MariaDB
- MySQLi
- Tailwind CSS via CDN: `@tailwindcss/browser@4`
- Session-based authentication

## Struktur Proyek

```text
TaskFlow/
├─ config/
│  └─ connection.php
├─ dashboard.php
├─ detail_tugas.php
├─ edit_tugas.php
├─ index.php
├─ logout.php
├─ proses_edit_tugas.php
├─ proses_login.php
├─ proses_register.php
├─ proses_tambah_tugas.php
├─ register.php
├─ registrasi.php
├─ tugas.php
└─ README.md
```

## Arsitektur Singkat

Aplikasi mengikuti pola sederhana:
- Halaman UI (GET): menampilkan form/tabel/detail
- Halaman proses (POST): memproses data lalu redirect
- Koneksi DB terpusat di `config/connection.php`
- Session dipakai untuk menyimpan status login

## Prasyarat

- PHP 7.4+ (disarankan PHP 8.1+)
- MySQL 5.7+ atau MariaDB setara
- Web server (Apache/Nginx) atau XAMPP/Laragon

## Konfigurasi Lokal

1. Clone/copy project ke web root.
2. Buat database baru, misalnya: `taskflow`.
3. Import skema SQL (lihat bagian Database).
4. Sesuaikan kredensial DB di `config/connection.php`:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "taskflow";
```

5. Jalankan aplikasi melalui browser:
   - `http://localhost/TaskFlow/index.php`

## Database

Berdasarkan implementasi kode, aplikasi membutuhkan minimal 2 tabel: `users` dan `tasks`.

### SQL yang direkomendasikan

```sql
CREATE DATABASE IF NOT EXISTS taskflow CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE taskflow;

CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','anggota') DEFAULT 'anggota',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tasks (
    id_task INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    id_user INT NULL,
    status ENUM('belum mulai','on progress','selesai') DEFAULT 'belum mulai',
    deadline DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_tasks_user FOREIGN KEY (id_user)
        REFERENCES users(id_user)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

-- Seed admin (password: admin123)
INSERT INTO users (nama, username, password, role)
VALUES (
  'Administrator',
  'admin',
  '$2y$10$gaR3Em4B4Q5lJxFGdXxKre0mMFej3mxrMZxhzSYhMxQxDpk8Y1fPu',
  'admin'
)
ON DUPLICATE KEY UPDATE username = username;
```

> Catatan: hash password di atas menggunakan `password_hash` (BCRYPT).

## Alur Halaman

### 1) Autentikasi

- `index.php`
  - Form login
  - Mengirim data ke `proses_login.php`

- `proses_login.php`
  - Mencari user berdasarkan username
  - Verifikasi password dengan `password_verify`
  - Jika valid: set `$_SESSION['id_user']` dan `$_SESSION['nama']`, redirect ke `dashboard.php`
  - Jika gagal: set pesan error, redirect kembali ke `index.php`

- `register.php`
  - Form registrasi
  - Mengirim data ke `proses_register.php`

- `proses_register.php`
  - Simpan user baru
  - Password di-hash dengan `password_hash`

- `logout.php`
  - `session_destroy()`
  - Redirect ke login

### 2) Dashboard

- `dashboard.php`
  - Wajib login (`$_SESSION['id_user']`)
  - Menampilkan jumlah tugas:
    - Total
    - Belum mulai
    - On progress
    - Selesai

### 3) Manajemen Tugas

- `tugas.php`
  - Wajib login
  - Menampilkan daftar tugas + nama PIC
  - Filter berdasarkan status (`GET status`)
  - Aksi ke detail/edit/hapus

- `detail_tugas.php`
  - Menampilkan detail 1 tugas berdasarkan `id`

- `edit_tugas.php`
  - Form edit tugas
  - Submit ke `proses_edit_tugas.php`

- `proses_edit_tugas.php`
  - Update data tugas
  - Redirect ke daftar tugas

- `proses_tambah_tugas.php`
  - Menyimpan tugas baru
  - Redirect ke daftar tugas

## Endpoint Mapping

### Halaman (GET)
- `/index.php` - login
- `/register.php` - registrasi
- `/dashboard.php` - ringkasan tugas
- `/tugas.php` - daftar tugas
- `/detail_tugas.php?id={id_task}` - detail tugas
- `/edit_tugas.php?id={id_task}` - edit tugas
- `/logout.php` - logout

### Proses (POST)
- `/proses_login.php`
- `/proses_register.php`
- `/proses_edit_tugas.php`
- `/proses_tambah_tugas.php`

## Catatan Penting (Kondisi Saat Ini)

Dari kode saat ini, ada beberapa referensi file yang belum ada di repository:

- `dashboard.php` dan `tugas.php` melakukan redirect ke `login.php`, tetapi file login yang tersedia adalah `index.php`.
- Menu navbar mengarah ke `tambah_tugas.php`, tetapi file form halaman tambah belum ada (hanya proses backend `proses_tambah_tugas.php`).
- Menu navbar mengarah ke `anggota.php`, tetapi file tersebut belum ada.
- Aksi hapus mengarah ke `hapus_tugas.php`, tetapi file tersebut belum ada.

Ada juga duplikasi proses registrasi:
- `proses_register.php`
- `registrasi.php`

Keduanya melakukan fungsi mirip, tetapi query kolom berbeda.

## Risiko Keamanan yang Perlu Ditingkatkan

Implementasi saat ini masih rentan dan sebaiknya ditingkatkan sebelum dipakai produksi:

- SQL Injection:
  - Banyak query menggunakan interpolasi langsung variabel (`'$username'`, `'$id'`, dll)
  - Solusi: gunakan prepared statements (`mysqli_prepare`) di semua query input user

- Validasi input:
  - Belum ada validasi server-side yang ketat (panjang teks, format, whitelist status)

- Otorisasi:
  - Akses data belum dibatasi per role/per user secara konsisten

- CSRF protection:
  - Form belum memiliki CSRF token

- XSS:
  - Output data ke HTML belum di-escape dengan `htmlspecialchars`

## Rekomendasi Pengembangan Lanjutan

1. Lengkapi file yang belum ada:
   - `tambah_tugas.php`
   - `hapus_tugas.php`
   - `anggota.php`
2. Samakan rute login ke `index.php` atau buat `login.php` sebagai alias.
3. Konsolidasikan registrasi: pilih satu file proses saja.
4. Refactor query ke prepared statement.
5. Tambahkan middleware auth sederhana agar halaman private konsisten.
6. Tambahkan pagination + pencarian pada daftar tugas.
7. Tambahkan upload lampiran tugas (opsional).

## Contoh Akun Uji

Jika seed admin dipakai:
- Username: `admin`
- Password: `admin123`

## Troubleshooting

- Gagal koneksi database
  - Pastikan MySQL berjalan
  - Cek host/user/password di `config/connection.php`
  - Pastikan database `taskflow` sudah dibuat

- Login selalu gagal
  - Pastikan password di database berupa hash dari `password_hash`
  - Jangan simpan password plaintext

- Styling tidak muncul
  - Pastikan koneksi internet aktif karena Tailwind diambil dari CDN

## Lisensi

Belum ditentukan.

Jika ingin dibuka sebagai open-source, bisa gunakan lisensi MIT.
