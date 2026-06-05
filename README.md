# Sistem Manajemen Dapur Takjil Ramadhan

## Overview Project

Pada pengembangan **Week 4** ini, proyek telah bertransformasi sepenuhnya dari PHP Native menjadi aplikasi berbasis _framework_ **Laravel**. Perubahan ini difokuskan pada perombakan struktur kode (_Code Refactoring_) menggunakan arsitektur **MVC (Model-View-Controller)** dan _templating engine_, tanpa merubah fungsionalitas dan fitur asli dari aplikasi.

---

## Fitur Sistem

Fitur pada aplikasi ini tetap dipertahankan seperti pada pengerjaan Week 3, namun kini berjalan di atas "mesin" Laravel:

1. **Sistem Autentikasi Login (Laravel Session):** Proteksi halaman menggunakan sistem sesi bawaan Laravel.
2. **Fitur Remember Me (Laravel Cookies):** Menggunakan _helper_ `cookie()` Laravel yang terenkripsi secara _default_ untuk keamanan ekstra.
3. **Sapaan Pengguna Dinamis:** Mengambil data dari `session('username')` dan menampilkannya melalui Blade.
4. **Dark Mode & Manajemen Stok Real-time:** Tetap menggunakan interaktivitas JavaScript dan _Web Storage API_ (Local Storage & Session Storage).

---

## Struktur Direktori Proyek (Laravel Architecture)

Pemisahan struktur menjadi jauh lebih rapi karena aset publik, logika pemrosesan, dan kerangka tampilan dipisahkan ke dalam direktori spesifik:

    dapur-takjil-laravel/
    │
    ├── app/Http/Controllers/
    │   └── AuthController.php    # Otak logika aplikasi (Login, Logout, Session, View routing)
    │
    ├── public/
    │   ├── css/style.css         # Aset statis CSS yang dapat diakses publik
    │   ├── js/script.js          # Aset statis JS
    │   └── assets/               # Gambar dan favicon
    │
    ├── resources/views/
    │   ├── layouts/
    │   │   └── main.blade.php    # Master Template (Navbar & Footer dinamis)
    │   ├── index.blade.php       # Tampilan Beranda (Katalog Menu)
    │   ├── kelola.blade.php      # Tampilan Form Kelola Data
    │   └── login.blade.php       # Tampilan Form Autentikasi
    │
    ├── routes/
    │   └── web.php               # Pengatur lalu lintas URL (Routing)
    │
    └── README.md                 # Dokumentasi proyek

---

## Penjelasan Teknis Transformasi

1. **Routing System (`routes/web.php`):**
   Pengguna tidak lagi mengakses file `.php` secara langsung (seperti `localhost/login.php`). Semua permintaan URL dicegat oleh Laravel _Router_ dan diarahkan ke _Controller_ yang tepat.
2. **Controller (`AuthController`):**
   Logika bisnis dan proteksi halaman yang sebelumnya berantakan di bagian atas file HTML, kini dipusatkan di _Controller_. _Controller_ bertugas mengecek sesi, memvalidasi data _login_, mengatur _cookies_, dan menentukan _View_ mana yang harus dirender.
3. **Blade Templating Engine (`.blade.php`):**
    - Mengeliminasi repetisi kode menggunakan `@extends('layouts.main')` dan `@section('content')`. Perubahan pada _Navbar_ atau _Footer_ kini cukup dilakukan di satu file `main.blade.php`.
    - Penulisan _output_ data jauh lebih bersih menggunakan sintaks kurung kurawal ganda `{{ }}` yang secara otomatis menjalankan fungsi keamanan `htmlspecialchars()` di latar belakang untuk mencegah injeksi XSS.
4. **Asset Management (`asset()` helper):**
   Pemanggilan file CSS, JS, dan gambar kini dibungkus menggunakan fungsi `asset()`. Hal ini memastikan Laravel selalu menghasilkan URL absolut yang mengarah ke folder `public/`, mencegah _error link_ rusak saat aplikasi di-_deploy_ ke server _production_.
