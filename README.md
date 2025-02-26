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

## 🚀 Tentang Bearry Laundry

**Bearry Laundry** adalah sebuah sistem manajemen layanan laundry yang dibangun dengan framework Laravel. Sistem ini dirancang untuk memudahkan pengelolaan transaksi, pelanggan, petugas, dan laporan keuangan untuk bisnis laundry. Dengan antarmuka yang intuitif dan fitur yang lengkap, Bearry Laundry membantu pemilik bisnis laundry dalam mengelola operasional sehari-hari secara efisien.

### 🌟 Fitur Utama
- ✅ **Manajemen Pelanggan**: Daftar pelanggan dengan tipe membership atau guest.
- 👨‍💼 **Manajemen Petugas**: Pengelolaan data petugas dan akun pengguna.
- 🧺 **Transaksi Laundry**: Proses transaksi laundry dengan detail jenis cucian, berat, dan harga.
- 🎁 **Diskon Otomatis**: Diskon otomatis untuk pelanggan membership berdasarkan jumlah transaksi atau berat cucian.
- 📊 **Laporan Keuangan**: Statistik pemasukan harian, mingguan, dan bulanan.
- 📁 **Export Data**: Fitur export data transaksi ke format yang diinginkan.
- 🔔 **Notifikasi**: Notifikasi real-time untuk pembaruan status transaksi.

## 🛠 Teknologi yang Digunakan
- 🚀 **Laravel**: Framework PHP untuk pengembangan aplikasi web.
- 🏗 **Filament**: Admin panel modern untuk manajemen data.
- 💾 **MySQL**: Database untuk menyimpan data pelanggan, transaksi, dan lainnya.
- 🎨 **Tailwind CSS**: Framework CSS untuk desain antarmuka yang responsif.
- ⚡ **Livewire**: Membuat komponen interaktif tanpa perlu JavaScript.

## 📌 Instalasi

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
   - Salin file `.env.example` menjadi `.env`.
   - Konfigurasi database di file `.env`.
   - Generate key aplikasi:
     ```bash
     php artisan key:generate
     ```

4. **Migrasi Database**:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   ```

6. **Akses Aplikasi**:
   Buka browser dan akses `http://localhost:8000`.

## 📖 Dokumentasi

Untuk dokumentasi lengkap tentang cara menggunakan Bearry Laundry, silakan kunjungi [Bearry Laundry Documentation](https://docs.bearrylaundry.com). Dokumentasi ini mencakup panduan instalasi, konfigurasi, dan penggunaan fitur-fitur utama.

## 🤝 Kontribusi

Kami sangat menghargai kontribusi dari komunitas. Jika Anda ingin berkontribusi, silakan ikuti panduan berikut:

1. **Fork Repository**:
   - Fork repository ini ke akun GitHub Anda.

2. **Buat Branch**:
   - Buat branch baru untuk fitur atau perbaikan:
     ```bash
     git checkout -b fitur-baru
     ```

3. **Commit Perubahan**:
   - Lakukan perubahan dan commit:
     ```bash
     git commit -am 'Menambahkan fitur baru'
     ```

4. **Push ke Branch**:
   - Push perubahan ke branch Anda:
     ```bash
     git push origin fitur-baru
     ```

5. **Buat Pull Request**:
   - Buat Pull Request ke repository utama dengan deskripsi yang jelas tentang perubahan yang Anda lakukan.

## 📜 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT). Ini berarti Anda bebas menggunakan, memodifikasi, dan mendistribusikan kode ini untuk keperluan pribadi maupun komersial, asalkan menyertakan atribusi kepada penulis asli.

```text
MIT License

© 2023 Bearry Laundry

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 🌍 Sosial Media

Jika Anda ingin mengikuti atau terhubung dengan saya, silakan kunjungi:
- 📷 **Instagram**: [@fazwxs](https://instagram.com/fazwxs)
- 💼 **LinkedIn**: [Fatir Zaidan Putra](https://www.linkedin.com/in/fatir-zaidan-putra-20250132a/)

## 📧 Kontak

Jika Anda memiliki pertanyaan, masukan, atau masalah teknis, silakan hubungi kami melalui:

- ✉️ **Email**: [support@bearrylaundry.com](mailto:support@bearrylaundry.com)
- 🌐 **Website**: [Bearry Laundry](https://bearrylaundry.com)
- 🛠 **Issue Tracker**: [GitHub Issues](https://github.com/bearrylaundry/bearry-laundry/issues)

Kami akan berusaha merespons secepat mungkin. Terima kasih atas dukungan Anda! 🚀