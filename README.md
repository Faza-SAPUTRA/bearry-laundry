<p align="center">
  <a href="https://bearrylaundry.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Bearry Laundry Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/bearrylaundry/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# 🧼 Bearry Laundry - Sistem Manajemen Laundry Profesional

**Bearry Laundry** adalah sebuah sistem manajemen layanan laundry berbasis **Laravel** yang dirancang untuk membantu bisnis laundry dalam mengelola transaksi, pelanggan, petugas, serta laporan keuangan dengan lebih efisien.

🚀 **Fitur Utama:**
- **👥 Manajemen Pelanggan** – Mendukung tipe pelanggan Guest & Membership.
- **👨‍💼 Manajemen Petugas** – Kelola akun petugas dengan peran berbeda.
- **💰 Transaksi & Pembayaran** – Mendukung berbagai metode pembayaran.
- **🔔 Notifikasi Real-Time** – Update status pesanan langsung ke pelanggan.
- **📊 Laporan Keuangan** – Statistik harian, mingguan, dan bulanan.
- **📂 Export Data** – Simpan laporan transaksi dalam berbagai format.

## 🛠 Teknologi yang Digunakan
- **Laravel** – Backend framework modern dan fleksibel.
- **Filament** – Admin panel yang ringan dan powerful.
- **MySQL** – Penyimpanan data pelanggan & transaksi.
- **Tailwind CSS** – Desain responsif dan minimalis.
- **Livewire** – Komponen interaktif tanpa JavaScript.

---

## 🚀 Instalasi

1. **Clone Repository**:
   ```bash
   git clone https://github.com/bearrylaundry/bearry-laundry.git
   cd bearry-laundry
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database & Migrasi**:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   ```
   Buka browser dan akses **http://localhost:8000**.

---

## 📂 Struktur Kode

### 📌 **Manajemen Pelanggan**
- **Model:** `Customer`
- **Resource:** `CustomerResource`
- **Fitur:** Tambah/edit pelanggan, validasi nomor telepon, tipe pelanggan (Guest/Membership).

```php
class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
}
```

### 📌 **Manajemen Petugas**
- **Model:** `Petugas`
- **Resource:** `PetugasResource`
- **Fitur:** Tambah/edit petugas, akun pengguna, hak akses.

```php
class PetugasResource extends Resource
{
    protected static ?string $model = Petugas::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
}
```

### 📌 **Transaksi Laundry**
- **Model:** `Transaksi`
- **Resource:** `TransaksiResource`
- **Fitur:** Detail jenis cucian, berat, harga, diskon otomatis, estimasi pengambilan.

```php
class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
}
```

---

## 📚 Dokumentasi
Untuk panduan lengkap instalasi dan penggunaan, kunjungi **[Bearry Laundry Documentation](https://docs.bearrylaundry.com)**.

---

## 🎯 Kontribusi
Kami menyambut kontribusi dari komunitas! Ikuti langkah-langkah berikut:

1. **Fork Repository**
2. **Buat Branch Baru**:  
   ```bash
   git checkout -b fitur-baru
   ```
3. **Commit Perubahan**:  
   ```bash
   git commit -am "Menambahkan fitur baru"
   ```
4. **Push ke GitHub**:  
   ```bash
   git push origin fitur-baru
   ```
5. **Buat Pull Request** ke repository utama.

---

## 📜 Lisensi
Proyek ini dilisensikan di bawah **MIT License**.  
Anda bebas menggunakan, memodifikasi, dan mendistribusikan kode ini dengan tetap menyertakan atribusi kepada penulis asli.

```
MIT License
Permission is hereby granted, free of charge, to any person obtaining a copy of this software...
```

---

## 💖 Sponsor
Terima kasih kepada sponsor yang mendukung pengembangan Bearry Laundry:
- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**

Ingin menjadi sponsor? Hubungi kami di **[sponsor@bearrylaundry.com](mailto:sponsor@bearrylaundry.com)**.

---

## 📩 Kontak
Jika ada pertanyaan, silakan hubungi kami:

📧 **Email**: [support@bearrylaundry.com](mailto:support@bearrylaundry.com)  
🌍 **Website**: [bearrylaundry.com](https://bearrylaundry.com)  
🛠 **Laporkan Bug**: [GitHub Issues](https://github.com/bearrylaundry/bearry-laundry/issues)

Terima kasih telah menggunakan **Bearry Laundry**! 🚀
