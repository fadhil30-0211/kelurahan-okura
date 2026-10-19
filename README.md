# Website Kelurahan Okura

Website layanan dan informasi Kelurahan Tebing Tinggi Okura. Warga dapat membaca informasi kelurahan, mengajukan layanan, menyampaikan pengaduan, mengusulkan data UMKM atau wisata, serta melacak pengajuan menggunakan kode tiket.

## Fitur Website

### Halaman Publik

- Beranda, profil, pencarian, berita, pengumuman, agenda, dan galeri.
- Direktori UMKM dan informasi wisata.
- Transparansi anggaran dan unduhan PDF.
- Pengajuan layanan surat dan pelacakan status.
- Pengaduan warga, termasuk opsi anonim.
- Pendaftaran atau usulan UMKM dan destinasi wisata.
- Pengajuan janji temu dan penilaian website.

### Panel Admin

Admin dapat mengelola berita, pengumuman, agenda, galeri, banner, UMKM, wisata, anggaran, dan informasi website. Panel juga menyediakan inbox untuk memproses layanan surat, pengaduan, janji temu, partisipasi warga, serta penilaian.

## Panduan untuk Warga

1. Buka halaman utama website.
2. Pilih menu informasi atau layanan yang dibutuhkan.
3. Isi formulir dengan data yang benar. Persyaratan dan batas ukuran berkas ditampilkan pada formulir.
4. Setelah pengajuan berhasil, simpan kode tiket atau halaman resi. Kode tersebut diperlukan untuk melacak pengajuan.

### Mengajukan Layanan Surat

1. Buka menu **Layanan Surat** atau alamat `/layanan`.
2. Pilih jenis surat dan lengkapi formulir. NIK harus terdiri dari 16 digit.
3. Unggah berkas persyaratan jika diminta. Berkas yang diterima berupa JPG, PNG, atau PDF dengan ukuran maksimal 2 MB per file.
4. Setelah pengajuan terkirim, simpan kode tiket pada halaman resi.
5. Untuk melacak status, gunakan kolom **Lacak Pengajuan** di halaman utama dan masukkan kode tiket serta NIK.

### Menyampaikan Pengaduan

1. Buka `/pengaduan`.
2. Isi kategori, judul, dan uraian pengaduan dengan jelas.
3. Nama dapat disamarkan dengan memilih opsi anonim. Nomor telepon tetap harus diisi.
4. Kirim pengaduan dan simpan kode tiket yang ditampilkan.
5. Lacak pengaduan melalui halaman pengaduan atau halaman resi.

### Mengusulkan UMKM atau Wisata

1. Buka `/daftar/umkm` untuk mengusulkan UMKM atau `/daftar/wisata` untuk mengusulkan destinasi wisata.
2. Isi data pemilik atau pengaju, informasi usaha atau lokasi, deskripsi, dan unggah foto.
3. Foto harus berupa JPG, JPEG, PNG, atau WebP dengan ukuran maksimal 2 MB.
4. Setelah formulir terkirim, simpan kode tiket. Pengajuan menunggu pemeriksaan admin.

### Mengajukan Janji Temu

1. Buka `/janji-temu`.
2. Isi nama, nomor telepon, keperluan, dan tanggal yang diinginkan.
3. Kirim formulir dan simpan kode tiket pada halaman resi.

### Halaman Informasi

| Informasi | Alamat |
| --- | --- |
| Profil kelurahan | `/profil` |
| Berita | `/berita` |
| Pengumuman | `/pengumuman` |
| Agenda | `/agenda` |
| Galeri | `/galeri` |
| UMKM | `/umkm` |
| Wisata | `/wisata` |
| Transparansi anggaran | `/transparansi-anggaran` |
| Pencarian | `/cari` |

## Panduan untuk Admin

1. Buka `/admin/login`.
2. Masuk dengan akun admin yang disiapkan untuk instalasi tersebut.
3. Gunakan dashboard dan menu admin untuk mengelola konten atau membuka inbox pengajuan.
4. Periksa data dan lampiran sebelum memperbarui status layanan surat, pengaduan, janji temu, atau pendaftaran UMKM/wisata.
5. Pilih **Keluar** setelah selesai menggunakan panel.

Menu pengelolaan pegawai, akun pengguna, dan pengaturan tertentu hanya tersedia untuk akun `super_admin`.

### Akun Awal untuk Pengembangan Lokal

Seeder menyediakan akun berikut untuk database lokal baru setelah menjalankan `php artisan migrate --seed`:

| Email            | Password      | Peran       |
| ---              | ---           | ---         |
| `admin@okura.id` | `password123` | Super admin |
| `lurah@okura.id` | `password123` | Lurah       |

Akun dan password ini hanya untuk pengembangan lokal. Ganti password sebelum aplikasi digunakan di lingkungan bersama atau produksi. Jangan menyimpan kredensial produksi di repositori.

## Menjalankan Project Secara Lokal

### Persyaratan

- PHP 8.3 atau lebih baru dan Composer.
- Node.js dan npm.
- MySQL, misalnya melalui XAMPP, jika menggunakan konfigurasi database MySQL.

### Instalasi dengan XAMPP dan MySQL

1. Jalankan MySQL dari XAMPP dan buat database, misalnya `kelurahan_okura`.
2. Dari folder project, instal dependency PHP:

   ```powershell
   composer install
   ```

3. Jika file `.env` belum ada, buat dari contoh:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Atur URL dan koneksi database di `.env`:

   ```dotenv
   APP_URL=http://127.0.0.1:8000
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kelurahan_okura
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Sesuaikan nama database, username, dan password dengan konfigurasi MySQL lokal. Jangan mengganti `.env` yang sudah berisi konfigurasi kerja tanpa menyimpan nilainya terlebih dahulu.

5. Buat application key, jalankan migration dan seeder, lalu buat tautan storage publik:

   ```powershell
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

   Jalankan seeder pada database baru. Beberapa seeder data contoh dapat membuat duplikat jika dijalankan berulang kali.

6. Instal dependency frontend dan build aset:

   ```powershell
   npm install
   npm run build
   ```

7. Jalankan aplikasi:

   ```powershell
   php artisan serve
   ```

8. Buka `http://127.0.0.1:8000` di browser. Halaman login admin tersedia di `http://127.0.0.1:8000/admin/login`.

Untuk pengembangan frontend dengan hot reload, jalankan `npm run dev` di terminal terpisah. Script Composer berikut juga dapat menjalankan server Laravel, queue worker, log viewer, dan Vite sekaligus:

```powershell
composer run dev
```

## Pengujian

Jalankan pengujian aplikasi dengan:

```powershell
php artisan test
```

## Struktur Project

Dokumentasi struktur folder dan file project tersedia di [STRUKTUR_FOLDER.md](STRUKTUR_FOLDER.md).
