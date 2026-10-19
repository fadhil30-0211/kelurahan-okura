# Struktur Folder Project Kelurahan Okura

Project ini menggunakan Laravel dan Vite. Pohon berikut mencantumkan file source, konfigurasi, serta file storage yang ada saat dokumentasi dibuat. Isi `.git`, dependency, dan cache hasil generate diringkas karena dapat berubah saat aplikasi berjalan.

```text
kelurahan-okura/
├── app/
│   ├── Exports/
│   │   ├── LayananSuratExport.php
│   │   └── PengaduanExport.php
│   ├── Helpers/
│   │   └── NotifikasiHelper.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminPartisipasiController.php
│   │   │   │   ├── AdminPasswordResetController.php
│   │   │   │   ├── AdminPengaduanController.php
│   │   │   │   ├── AdminPenilaianController.php
│   │   │   │   ├── AgendaController.php
│   │   │   │   ├── AnggaranController.php
│   │   │   │   ├── BeritaController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EmergencyContactController.php
│   │   │   │   ├── GaleriController.php
│   │   │   │   ├── GalleryController.php
│   │   │   │   ├── HeroBannerController.php
│   │   │   │   ├── JanjiTemuController.php
│   │   │   │   ├── LayananSuratController.php
│   │   │   │   ├── PartisipasiController.php
│   │   │   │   ├── PegawaiController.php
│   │   │   │   ├── PengaduanController.php
│   │   │   │   ├── PengumumanController.php
│   │   │   │   ├── ProfileController.php
│   │   │   │   ├── SettingController.php
│   │   │   │   ├── SiteSettingController.php
│   │   │   │   ├── SocialPostController.php
│   │   │   │   ├── TentangKknController.php
│   │   │   │   ├── UmkmController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── WisataController.php
│   │   │   ├── Auth/
│   │   │   │   ├── ForgotPasswordController.php
│   │   │   │   └── LoginController.php
│   │   │   ├── Frontend/
│   │   │   │   ├── AgendaController.php
│   │   │   │   ├── AnggaranController.php
│   │   │   │   ├── BeritaController.php
│   │   │   │   ├── GaleriController.php
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── JanjiTemuController.php
│   │   │   │   ├── LayananSuratController.php
│   │   │   │   ├── PartisipasiController.php
│   │   │   │   ├── PendaftaranController.php
│   │   │   │   ├── PengaduanController.php
│   │   │   │   ├── PengajuanController.php
│   │   │   │   ├── PengumumanController.php
│   │   │   │   ├── PenilaianController.php
│   │   │   │   ├── ProfilController.php
│   │   │   │   ├── ResiController.php
│   │   │   │   ├── SearchController.php
│   │   │   │   ├── TransparansiController.php
│   │   │   │   ├── UmkmController.php
│   │   │   │   ├── UniversalTrackingController.php
│   │   │   │   └── WisataController.php
│   │   │   ├── Controller.php
│   │   │   └── TrackingController.php
│   │   └── Middleware/
│   │       ├── EnsureCanApprove.php
│   │       └── EnsureIsSuperAdmin.php
│   ├── Models/
│   │   ├── Agenda.php
│   │   ├── Anggaran.php
│   │   ├── Berita.php
│   │   ├── EmergencyContact.php
│   │   ├── Galeri.php
│   │   ├── Gallery.php
│   │   ├── HeroBanner.php
│   │   ├── JanjiTemu.php
│   │   ├── LayananSurat.php
│   │   ├── PageView.php
│   │   ├── PartisipasiUmkm.php
│   │   ├── PartisipasiWisata.php
│   │   ├── PasswordResetRequest.php
│   │   ├── Pegawai.php
│   │   ├── Pengaduan.php
│   │   ├── Pengajuan.php
│   │   ├── Pengumuman.php
│   │   ├── Penilaian.php
│   │   ├── Profile.php
│   │   ├── Setting.php
│   │   ├── SiteSetting.php
│   │   ├── SocialPost.php
│   │   ├── TransparansiAnggaran.php
│   │   ├── Umkm.php
│   │   ├── UmkmGallery.php
│   │   ├── User.php
│   │   └── Wisata.php
│   ├── Providers/
│   │   ├── Filament/
│   │   │   └── AdminPanelProvider.php
│   │   └── AppServiceProvider.php
│   ├── Traits/
│   │   └── CompressesImages.php
│   └── Dockerfile
├── bootstrap/
│   ├── app.php
│   ├── providers.php
│   └── cache/                   # Cache bootstrap yang dihasilkan Laravel
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── image.php
│   ├── intervention-image.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_08_09_011638_add_role_to_users_table.php
│   │   ├── 2026_08_09_011714_create_pegawais_table.php.php
│   │   ├── 2026_08_09_011740_create_beritas_table.php.php
│   │   ├── 2026_08_09_011805_create_pengumumans_table.php.php
│   │   ├── 2026_08_09_011834_create_wisatas_table.php.php
│   │   ├── 2026_08_09_011905_create_umkms_table.php.php
│   │   ├── 2026_08_09_011925_create_pengaduans_table.php.php
│   │   ├── 2026_08_09_011951_create_layanan_surats_table.php.php
│   │   ├── 2026_08_09_073417_create_galeris_table.php.php
│   │   ├── 2026_08_09_073713_create_agendas_table.php.php
│   │   ├── 2026_08_09_074813_create_anggarans_table.php
│   │   ├── 2026_08_11_000004_create_hero_banners_table.php.php
│   │   ├── 2026_08_11_000042_create_galleries_table.php.php
│   │   ├── 2026_08_11_000201_create_janji_temus_table.php.php
│   │   ├── 2026_08_11_000454_create_emergency_contacts_table.php.php
│   │   ├── 2026_08_11_034515_add_pendaftaran_fields_to_wisatas_and_umkms_table.php.php
│   │   ├── 2026_08_11_081536_add_lurah_role_to_users_table.php.php
│   │   ├── 2026_08_11_083739_add_anonim_to_pengaduans_table.php.php
│   │   ├── 2026_08_11_122106_create_social_posts_table.php.php
│   │   ├── 2026_08_12_082140_add_notif_tracking_columns.php.php
│   │   ├── 2026_08_14_130310_create_site_settings_table.php.php
│   │   ├── 2026_08_18_144034_add_is_anonim_to_pengaduans_table.php
│   │   ├── 2026_08_19_140500_create_umkm_galleries_table.php
│   │   ├── 2026_08_26_132144_create_settings_table.php
│   │   ├── 2026_08_29_065912_add_nama_website_footer_to_settings_table.php
│   │   ├── 2026_09_03_074630_add_operating_hours_and_socials_to_settings_table.php
│   │   ├── 2026_09_08_100037_add_value_to_site_settings_table.php
│   │   ├── 2026_09_08_100751_add_key_to_site_settings_table.php
│   │   ├── 2026_09_17_154456_add_role_to_users_table.php
│   │   ├── 2026_09_18_045230_add_views_to_content_tables.php
│   │   ├── 2026_09_18_064442_add_views_to_pengumumans_table.php
│   │   ├── 2026_09_18_071440_add_views_to_umkms_table.php
│   │   ├── 2026_09_18_115244_create_profiles_table.php
│   │   ├── 2026_09_18_231215_add_map_columns_to_profils_table.php
│   │   ├── 2026_09_19_012907_create_password_resets_table.php
│   │   ├── 2026_09_19_112131_create_transparansi_anggarans_table.php
│   │   ├── 2026_09_20_134534_create_page_views_table.php
│   │   ├── 2026_09_20_164334_create_penilaians_table.php
│   │   ├── 2026_09_20_235145_create_partisipasi_umkms_table.php
│   │   ├── 2026_09_20_235146_create_partisipasi_wisatas_table.php
│   │   ├── 2026_09_21_081721_add_kode_tiket_to_partisipasi_umkms_table.php
│   │   ├── 2026_09_21_130553_add_kode_tiket_to_partisipasi_wisatas_table.php
│   │   └── 2026_09_21_130847_add_kode_tiket_to_partisipasi_wisatas_table.php
│   ├── seeders/
│   │   ├── AdminSeeder.php
│   │   ├── DatabaseSeeder.php
│   │   ├── LurahSeeder.php
│   │   ├── PegawaiSeeder.php
│   │   ├── SettingSeeder.php
│   │   ├── UmkmSeeder.php
│   │   └── WisataSeeder.php
│   └── .gitignore
│   └── database.sqlite
├── public/
│   ├── build/                   # Aset hasil build Vite (generated)
│   │   ├── assets/               # Bundle CSS, JavaScript, dan font dengan nama hash
│   │   ├── fonts-manifest.json
│   │   └── manifest.json
│   ├── geojson/
│   │   └── tebing-tinggi-okura.geojson
│   ├── images/
│   │   ├── avatar-placeholder.jpg
│   │   ├── hero-okura.jpg
│   │   ├── logo.png
│   │   └── placeholder.jpg
│   ├── logo/
│   │   └── logo2.png
│   ├── templates/
│   │   ├── sktm-template.pdf
│   │   └── sku-template.pdf
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   ├── logo.png
│   ├── robots.txt
│   └── storage                  # Tautan ke storage/app/public
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       │   ├── agenda/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── anggaran/
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── berita/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── emergency-contact/
│       │   │   └── index.blade.php
│       │   ├── galeri/
│       │   │   ├── create.blade.php
│       │   │   └── index.blade.php
│       │   ├── gallery/
│       │   │   └── index.blade.php
│       │   ├── hero-banner/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── janji-temu/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── layanan-surat/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── pegawai/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── partisipasi/
│       │   │   ├── umkm.blade.php
│       │   │   └── wisata.blade.php
│       │   ├── password_reset/
│       │   │   └── index.blade.php
│       │   ├── pengaduan/
│       │   │   ├── create.blade.php
│       │   │   ├── export-pdf.blade.php
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── pengaturan/
│       │   │   └── index.blade.php
│       │   ├── pengumuman/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── penilaian/
│       │   │   └── index.blade.php
│       │   ├── profile/
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── setting/
│       │   │   └── index.blade.php
│       │   ├── social-post/
│       │   │   └── index.blade.php
│       │   ├── tentang-kkn/
│       │   │   └── index.blade.php
│       │   ├── umkm/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── users/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── wisata/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   └── dashboard.blade.php
│       ├── auth/
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   └── reset-password.blade.php
│       ├── frontend/
│       │   ├── agenda/
│       │   │   └── index.blade.php
│       │   ├── anggaran/
│       │   │   └── index.blade.php
│       │   ├── berita/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── galeri/
│       │   │   └── index.blade.php
│       │   ├── janji-temu/
│       │   │   ├── create.blade.php
│       │   │   ├── track-result.blade.php
│       │   │   └── track.blade.php
│       │   ├── layanan/
│       │   │   ├── create.blade.php
│       │   │   ├── index.blade.php
│       │   │   ├── track-result.blade.php
│       │   │   └── track.blade.php
│       │   ├── partials/
│       │   │   ├── seo-meta.blade.php
│       │   │   └── widget-survei.blade.php
│       │   ├── partisipasi/
│       │   │   ├── create.blade.php
│       │   │   └── index.blade.php
│       │   ├── pendaftaran/
│       │   │   ├── umkm.blade.php
│       │   │   └── wisata.blade.php
│       │   ├── pengaduan/
│       │   │   ├── create.blade.php
│       │   │   ├── lacak.blade.php
│       │   │   ├── track-result.blade.php
│       │   │   └── track.blade.php
│       │   ├── pengajuan/
│       │   │   └── lacak.blade.php
│       │   ├── pengumuman/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── penilaian/
│       │   │   └── index.blade.php
│       │   ├── resi/
│       │   │   ├── pdf.blade.php
│       │   │   └── show.blade.php
│       │   ├── umkm/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── wisata/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── index.blade.php
│       │   ├── lacak.blade.php
│       │   ├── profil.blade.php
│       │   ├── search.blade.php
│       │   ├── show.blade.php
│       │   └── tracking-detail.blade.php
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   ├── app.blade.php
│       │   ├── dashboard.blade.php
│       │   └── frontend.blade.php
│       ├── pages/
│       │   └── direktori-umkm.blade.php
│       ├── vendor/
│       │   └── pagination/
│       │       ├── bootstrap-3.blade.php
│       │       ├── bootstrap-4.blade.php
│       │       ├── bootstrap-5.blade.php
│       │       ├── semantic-ui.blade.php
│       │       ├── simple-bootstrap-3.blade.php
│       │       ├── simple-bootstrap-4.blade.php
│       │       ├── simple-bootstrap-5.blade.php
│       │       ├── simple-tailwind.blade.php
│       │       └── tailwind.blade.php
│       ├── transparansi-anggaran.blade.php
│       └── welcome.blade.php
├── routes/
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   │   ├── private/
│   │   │   └── .gitignore
│   │   ├── public/
│   │   │   ├── berita/
│   │   │   │   ├── 6kGmWtykxmf6hjMft5355vejllpT0uZcwt8Ce4E4.jpg
│   │   │   │   ├── 7TCp0g9uvhmgJlsw4XSvj13A2NJzR9rdPmGodoCk.jpg
│   │   │   │   ├── md6c61MUAQbgTnd2CBuxVHLAJDVOMiaMMvqp7XfP.jpg
│   │   │   │   ├── PumaAyis4XyG7z01j5ZqEPjcGS2mNwYVGrnZNvu6.jpg
│   │   │   │   └── VQaUb8gqqmLSi8coiJrzfiTwG0MJN5KnPnqPxNkJ.jpg
│   │   │   ├── galeri/
│   │   │   │   ├── 6k3Y5spR46RH3ZupuX5suOCdDWiV1MVWgDyroWK8.jpg
│   │   │   │   ├── aiO9rQxvzr1RLDxMGMJmwFQkJTtAYc5uLDwr3PBU.jpg
│   │   │   │   ├── ATTtXUwczFVBlKOP2eTiKRMHT9mRE5hemYBQbBHj.jpg
│   │   │   │   ├── berita/
│   │   │   │   │   ├── 89HtOuX286fwO6G5P69pIkSsFVwrckhQXjjpEwQ5.jpg
│   │   │   │   │   ├── 9XK2TTkVrsNL2kL6LsEmyK5vRKgrORNWFVH430OJ.jpg
│   │   │   │   │   ├── AEdprySd4vsOr3qbaQBoFscise1chv7vn0LjmYRR.jpg
│   │   │   │   │   ├── c1n198hroCI7u9V2SobQJIFMtXgfvLwePg1AkQyz.jpg
│   │   │   │   │   ├── jr26tmPLQ4SiMsZKaYvoc3OpSTaVPyj24hxjfeVo.jpg
│   │   │   │   │   ├── lsU6EMz3z4JJfGPKTGvKSZQMfFUmb7xOGxKL6OZ9.jpg
│   │   │   │   │   ├── Ne5rXhuF8NSOGHZwiBiZM3uASmymKVyMmsM7xHtu.jpg
│   │   │   │   │   ├── TJRk3on3i2OBJvsXzKNB71cxpZc6ngtw3BcipaD3.jpg
│   │   │   │   │   ├── WFs47JeACr2DLojU3Y6oxGLpWYoFLXwmdG2hyB9L.jpg
│   │   │   │   │   ├── WinmlfN45tvCxIzrOUXYj9LpzbQwlkatdp18MOn2.jpg
│   │   │   │   │   ├── xy9mFxbFRYmMPN0nRxI67jgiGNuqhRUiyVymTUdW.jpg
│   │   │   │   │   ├── zLr7rmJPoBvAmRUuWxw7KHsAs3wSWMqfXjUFSbYJ.jpg
│   │   │   │   │   └── zsqVeD8X8zPQkeFsJe3kI3Q86ucgWw2KcLYYyRGW.jpg
│   │   │   │   ├── wisata/
│   │   │   │   │   ├── 6v8gMv5X3Dhvk37mBcjmTyDm9FntKdHXJSi0V9Oz.jpg
│   │   │   │   │   ├── PHZ9SaGpR0WUVaMGPjGImh3CHV4ejs2uEg7CilfB.jpg
│   │   │   │   │   ├── umLxJnlJH1EUHC6UEraZ3pswinu0lUKkoSSLBTea.png
│   │   │   │   │   └── wKPDxOsYbdr2ix02tQZvL19T7xVgZPT2csOkOZF2.jpg
│   │   │   ├── geojson/
│   │   │   │   ├── AhyQB2nP861EaERfQGHBkAKf128OZzLWhHV7wiwN.json
│   │   │   │   ├── DhXduUp3eB2cRyrdF90BBwS2VYva7ythZDk5p1tX.json
│   │   │   │   └── eYGYTalVfzpxpRlDHQ3P4hQlRFJWiZvaRtGhBxeN.json
│   │   │   ├── hero-banners/
│   │   │   │   ├── M4SetX4ylVGnMzsGo37szwCIgC1xhjwkitngRFmQ.jpg
│   │   │   │   ├── sOcO3aFJeJGCWVLNvCwle5y035jvaDriCZ8DQqns.jpg
│   │   │   │   └── ZyX3KRTlRiWdKPVt3qVZRJ75xIWcXJ1zd1bBu1KV.jpg
│   │   │   ├── layanan-surat/
│   │   │   │   ├── 15HboR93X5lhMYhxLb2XPx9xxsjWRgwg1A2vIf1L.jpg
│   │   │   │   ├── 5OqmZ4X5fwFhD5QYDKbGlUBPGcyuv11hIQa1kNtw.pdf
│   │   │   │   ├── 73l8aL9BbMu1GssNZaCOVmBxqw38bz7Jfh2G2797.pdf
│   │   │   │   ├── ELoiEhboNkxI9aWkn7UvHfpXZ9XAvkyahRq62bU6.pdf
│   │   │   │   ├── HA6VSPjgqyjzw08o5VOZpoel6pYCU9VRpi572Kz5.jpg
│   │   │   │   ├── hasil/
│   │   │   │   │   ├── EtiDJN1sJwAjOhcBjvXccFPWZEw5uyp4zUKLgJ5P.pdf
│   │   │   │   │   └── GjencnGcu6FgkVnldqN1fiTLtF8yyWTU7pqXT983.pdf
│   │   │   │   ├── idJTLcL3YSFEU7KDaz8FKM68NWlgy0pDLVI8Epdi.pdf
│   │   │   │   ├── IMs0PoPc4EC7WcAgdS45vor8jSDfspr5zmuCuxbV.png
│   │   │   │   ├── lgh20WQY8ZMNTERGQFDqWwAtvTOHhthOv2qLQPEC.jpg
│   │   │   │   ├── Nv5eKqaUPFIPxIcMGJM6JaiaHDZvicDg5gyLeHen.pdf
│   │   │   │   ├── Uguph8uAtM7GrDsRikXSvLRAXVkRnV0sr7bBGL6i.pdf
│   │   │   │   ├── V1oEcijc1bw6bIReuUBG6PiBZ24rdRbuOhkOYFcC.pdf
│   │   │   │   ├── VSI3eXUy3zhMmpyFvIhDW3ddJ4ARUGptZtNpMZQA.jpg
│   │   │   │   └── ZCZRUOvQPgBb3LWmN45AequkxqyLSvgUBX9HQHTb.pdf
│   │   │   ├── logo/
│   │   │   │   ├── Logo gokura.png
│   │   │   │   └── Logo usti.png
│   │   │   ├── pegawai/
│   │   │   │   ├── 0TpQg2XpUzIcJjfu9poUntfI0bdvgkUwJxkgE0Kq.jpg
│   │   │   │   ├── EYLB1OwpKucRpPVsiVSxjXusMuBeCjuUUTuvJxKX.jpg
│   │   │   │   ├── lM6ZupQcV96vi10qfnbgPc5GW1IlqpObYKEVEnEl.jpg
│   │   │   │   ├── uuZufAdIOnD2SDTJI1LMDjpG1l0idkOF4aUrIe5O.jpg
│   │   │   │   ├── VKEQtjGNAVpxHEZS7oT7an2xRzYPNMT06Wo9gvnk.jpg
│   │   │   │   └── yL0WrcOmC8TBJdXg8TWVRgLXvxxXdK91fsKYQmvx.jpg
│   │   │   ├── pengaduan/
│   │   │   │   ├── 1gA2gExrU5d2DdxAGicHgDkyiIbG2Pe5LDGRPYcb.jpg
│   │   │   │   ├── 4VTTILKrZ6s7nm6g4ZJvyf9HVba1aXUYlBQg0Q2i.jpg
│   │   │   │   ├── cN1SlMLv8boFIdxBtc64NAvaYPR3Mujrzwjt8L9h.jpg
│   │   │   │   ├── DiHcquRtuHlR7PTq1zMBxe1777VRroJA0N8Jv1br.jpg
│   │   │   │   ├── H7QuF9rKrTHIq8Q3oHTls1sQ9klaNHyBjKJBuHTi.jpg
│   │   │   │   ├── JWBCdiOmTb8rZOjQFcMLGfCBDCCdeKaT86poXnTb.jpg
│   │   │   │   ├── uwNrHWVQEecHd110bx5tNVASP1aXlighd6LBTdq8.jpg
│   │   │   │   ├── V3Ku61aB8xAtPOzhF28wsK6mlEH3EDJQ4Tzys8n8.jpg
│   │   │   │   └── xpnguUBc93dEMTsbd6cu275CfRoIQXP9R9EvcwkL.jpg
│   │   │   ├── pengumuman/
│   │   │   │   ├── 3a75wYPpvnvgRy6wWkfBB0PNSy4TIgajuX7TbUyY.jpg
│   │   │   │   ├── B8DDjFiBAU1eOvv3IQ0dGo0UeYZmVumS74vQdpCh.pdf
│   │   │   │   ├── fao8pq4yd0dL0SLPwOvpYHmhNAe21vdhW75abD9A.pdf
│   │   │   │   ├── MvSVPVJvU5sPQcYaRf2iCM4H25yZdsE6idwPEh4T.pdf
│   │   │   │   ├── nHAqftrMMp8uRsj6i9xjp8QESqJccFanw4uQM1c0.pdf
│   │   │   │   ├── nqvli9RuBxsXaMjBmNiaS8aDhZXj9uuAAz4aqyWb.pdf
│   │   │   │   ├── r8H2epJ3lslcMAJ7yPjjAVKzbc51UKNOFv1XwnTS.pdf
│   │   │   │   ├── xJPXvwg3B191Czvi47ZNAgJXN84Zovd9ppwiwM0Y.pdf
│   │   │   │   └── y4eb8cELCvqN2NO5eM79B8pNgRvjbPVr4YxuiY9p.pdf
│   │   │   ├── profil/
│   │   │   │   ├── adam-clear.png
│   │   │   │   ├── andika-clear.png
│   │   │   │   ├── bunga-clear.png
│   │   │   │   ├── cika-clear.png
│   │   │   │   ├── daffa-clear.png
│   │   │   │   ├── fadhilr.png
│   │   │   │   ├── fadilm.png
│   │   │   │   ├── fahmi-clear.png
│   │   │   │   ├── rafa-clear.png
│   │   │   │   ├── rama-clear.png
│   │   │   │   ├── serik-clear.png
│   │   │   │   └── wahyu-clear.png
│   │   │   ├── settings/
│   │   │   │   └── i9bcvT0CqKDI7BgTdzSLdM2I4KqpWtkOd5jdGXK7.png
│   │   │   ├── umkm/
│   │   │   │   ├── 1Jh3DadpXogQc9FvVfO9GzpEUFcEKhsJcfMRGLtY.jpg
│   │   │   │   ├── 5rP22mOc0A8UBgG806d1iRJQuJsZXctTEQ74FN1G.jpg
│   │   │   │   ├── 7jmRVCCjx0uyjz6g4hncW1EPkCTYP3dL4AHGk6iw.jpg
│   │   │   │   ├── asSBjqyz46ahQf2siDNsTYdyP7sbluO2HpUhdi1X.jpg
│   │   │   │   ├── KbnbYfY2GJZ0oDvh2SYK52EXKLphqlyIK0mIgJ5R.jpg
│   │   │   │   ├── rrB1VLYofwCclCoH1hQdRPemVd1YcmHty2YPnEGl.jpg
│   │   │   │   ├── rrwLzGVtNElUPz9XZezQJwtCzZ1Pm23KalWPxv4I.jpg
│   │   │   │   ├── y9XGNlar52ei4qsne7f0qgMf4aTYjsIO1fq7o3GT.jpg
│   │   │   │   └── Z8Vb1Hcnygq0Km1mj69alQnj3fmBmNfdv2WOho3n.jpg
│   │   │   ├── wisata/
│   │   │   │   ├── 2zJkUAM44pt2FEGDrbuXTngtRsIO5E0yN1wo8h5P.jpg
│   │   │   │   └── A6cVgqtVYsFUnMqm94mTnoHakjavCXa87jNZlxn5.jpg
│   │   │   ├── .gitignore
│   │   │   └── logo2.png
│   │   └── .gitignore
│   ├── framework/
│   │   ├── cache/
│   │   │   ├── data/.gitignore
│   │   │   └── .gitignore
│   │   ├── sessions/.gitignore
│   │   ├── testing/.gitignore
│   │   ├── views/.gitignore
│   │   └── .gitignore
│   └── logs/
│       ├── .gitignore
│       └── laravel.log
├── tests/
│   ├── Feature/
│   │   └── ExampleTest.php
│   ├── Unit/
│   │   └── ExampleTest.php
│   └── TestCase.php
├── vendor/                     # Dependency PHP dari Composer
├── node_modules/                # Dependency frontend dari npm
├── .vscode/
│   └── settings.json
├── .editorconfig
├── .env                         # Konfigurasi lokal; jangan dibagikan
├── .env.example
├── .gitattributes
├── .gitignore
├── .npmrc
├── CLAUDE.MD
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── phpunit.xml
├── README.md
└── vite.config.js
```

## Catatan

- Isi folder `resources/views/admin/` dan `resources/views/frontend/` dibagi lagi per fitur. File Blade di dalamnya mencakup halaman daftar, detail, formulir, pelacakan, dan komponen parsial.
- `public/build/`, `vendor/`, dan `node_modules/` berisi file hasil build atau dependency, sehingga isinya tidak dirinci satu per satu.
- `storage/` dan `bootstrap/cache/` berisi data runtime/cache yang dapat berubah saat aplikasi berjalan.
- File unggahan yang ada di `storage/app/public/` dicantumkan berdasarkan kondisi saat dokumen ini dibuat. Cache Blade terkompilasi di `storage/framework/views/` tidak dirinci karena dibuat ulang oleh Laravel.
- `.env` memuat konfigurasi lokal dan dapat berisi informasi sensitif. Gunakan `.env.example` sebagai acuan konfigurasi tanpa membagikan nilai rahasia.
