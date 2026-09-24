<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Import Models
use App\Models\Pengaduan;
use App\Models\PartisipasiWisata;
use App\Models\PartisipasiUmkm;
use App\Models\LayananSurat;

// Import Controllers - Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\WisataController;
use App\Http\Controllers\Frontend\UmkmController;
use App\Http\Controllers\Frontend\BeritaController as FrontendBeritaController;
use App\Http\Controllers\Frontend\PengaduanController;
use App\Http\Controllers\Frontend\PartisipasiController as FrontendPartisipasiController;
use App\Http\Controllers\Frontend\LayananSuratController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\JanjiTemuController;
use App\Http\Controllers\Frontend\ResiController;
use App\Http\Controllers\Frontend\PendaftaranController;
use App\Http\Controllers\Frontend\PengumumanController as FrontendPengumumanController;
use App\Http\Controllers\Frontend\GaleriController as FrontendGaleriController;
use App\Http\Controllers\Frontend\AgendaController as FrontendAgendaController;
use App\Http\Controllers\Frontend\PengajuanController;
use App\Http\Controllers\Frontend\ProfilController;
use App\Http\Controllers\Frontend\AnggaranController as FrontendAnggaranController;
use App\Http\Controllers\Frontend\PenilaianController;

// Import Controllers - Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Import Controllers - Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\WisataController as AdminWisataController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\Admin\AdminPengaduanController;
use App\Http\Controllers\Admin\PartisipasiController as AdminPartisipasiController;
use App\Http\Controllers\Admin\LayananSuratController as AdminLayananSuratController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\JanjiTemuController as AdminJanjiTemuController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\AnggaranController as AdminAnggaranController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\EmergencyContactController;
use App\Http\Controllers\Admin\SocialPostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TentangKknController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminPasswordResetController;
use App\Http\Controllers\Admin\AdminPenilaianController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (PUBLIK)
|--------------------------------------------------------------------------
*/

// Home, Profil & Pencarian
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/cari', [SearchController::class, 'index'])->name('search');

// Transparansi Anggaran
Route::get('/transparansi-anggaran', [FrontendAnggaranController::class, 'index'])->name('transparansi.index');
Route::get('/transparansi-anggaran/download-pdf', [FrontendAnggaranController::class, 'downloadPdf'])->name('transparansi.download-pdf');

// Pengumuman
Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
    Route::get('/', [FrontendPengumumanController::class, 'index'])->name('index');
    Route::get('/{pengumuman}', [FrontendPengumumanController::class, 'show'])->name('show');
});

// Galeri & Agenda
Route::get('/galeri', [FrontendGaleriController::class, 'index'])->name('galeri.index');
Route::get('/agenda', [FrontendAgendaController::class, 'index'])->name('agenda.index');

// Janji Temu Frontend
Route::prefix('janji-temu')->name('janji-temu.')->group(function () {
    Route::get('/', [JanjiTemuController::class, 'create'])->name('index');
    Route::get('/create', [JanjiTemuController::class, 'create'])->name('create');
    Route::post('/', [JanjiTemuController::class, 'store'])->name('store');
});

// Resi & Tracking Universal (Lacak Pengaduan, Wisata, UMKM, dan Layanan Surat)
Route::get('/resi/{kodeTiket}', [ResiController::class, 'show'])->name('resi.show');
Route::get('/resi/{kodeTiket}/download', [ResiController::class, 'download'])->name('resi.download');

Route::match(['get', 'post'], '/lacak-pengaduan', function (Request $request) {
    // Ambil kode dari request (query string ?kode=... saat GET atau input form saat POST)
    $kode = $request->input('kode') ?? $request->input('kode_tiket');

    // Jika diakses via HTTP GET (halaman dibuka biasa / direct link)
    if ($request->isMethod('get')) {
        return view('frontend.tracking-detail', [
            'kode' => $kode,
            'data' => null,
            'type' => null
        ]);
    }

    // Jika diakses via HTTP POST (form pencarian di-submit)
    $request->validate([
        'kode_tiket' => 'required|string',
    ], [
        'kode_tiket.required' => 'Masukkan kode tiket pengaduan atau pendaftaran Anda.',
    ]);

    $kode = trim($request->kode_tiket);
    $result = null;
    $type = null;

    // 1. Cek di tabel Pengaduan
    $result = Pengaduan::whereRaw('LOWER(kode_tiket) = ?', [strtolower($kode)])->first();
    if ($result) {
        $type = 'pengaduan';
    }

    // 2. Cek di tabel Partisipasi Wisata (WST-XXXXXX)
    if (!$result) {
        $result = PartisipasiWisata::whereRaw('LOWER(kode_tiket) = ?', [strtolower($kode)])->first();
        if ($result) {
            $type = 'wisata';
        }
    }

    // 3. Cek di tabel Partisipasi UMKM (UMKM-XXXXXX)
    if (!$result) {
        $result = PartisipasiUmkm::whereRaw('LOWER(kode_tiket) = ?', [strtolower($kode)])->first();
        if ($result) {
            $type = 'umkm';
        }
    }

    // 4. Cek di tabel Layanan Surat
    if (!$result && class_exists(LayananSurat::class)) {
        $result = LayananSurat::whereRaw('LOWER(kode_tiket) = ?', [strtolower($kode)])->first();
        if ($result) {
            $type = 'layanan_surat';
        }
    }

    // Jika data tidak ditemukan di tabel manapun
    if (!$result) {
        return back()->withErrors([
            'kode_tiket' => "Kode tiket '{$kode}' tidak ditemukan. Mohon periksa kembali kode Anda."
        ])->withInput();
    }

    return view('frontend.tracking-detail', [
        'kode' => $kode,
        'data' => $result,
        'type' => $type
    ]);
})->name('tracking.universal');

Route::get('/lacak-pengajuan', [PengajuanController::class, 'lacak'])->name('pengajuan.lacak');

// Wisata
Route::prefix('wisata')->name('wisata.')->group(function () {
    Route::get('/', [WisataController::class, 'index'])->name('index');
    Route::get('/usul', [PendaftaranController::class, 'createWisata'])->name('usul');
    Route::get('/{slug}', [WisataController::class, 'show'])->name('show');
});

// UMKM
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('index');
    Route::get('/daftar', [PendaftaranController::class, 'createUmkm'])->name('daftar');
    Route::get('/{id}', [UmkmController::class, 'show'])->name('show');
});

// Berita
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [FrontendBeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [FrontendBeritaController::class, 'show'])->name('show');
});

// Layanan Surat
Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', [LayananSuratController::class, 'index'])->name('index');
    Route::get('/ajukan/{jenis?}', [LayananSuratController::class, 'create'])->name('create');
    Route::post('/ajukan', [LayananSuratController::class, 'store'])->name('store');
    Route::get('/lacak', [LayananSuratController::class, 'trackForm'])->name('track.form');
    Route::post('/lacak', [LayananSuratController::class, 'track'])->name('track');
});

// Pengaduan Frontend
Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
    Route::get('/', [PengaduanController::class, 'create'])->name('create');
    Route::post('/', [PengaduanController::class, 'store'])->name('store');
    Route::get('/lacak', [PengaduanController::class, 'lacakForm'])->name('track.form');
    Route::post('/lacak', [PengaduanController::class, 'lacak'])->name('track');
});

// Partisipasi Warga Frontend
Route::prefix('partisipasi')->name('partisipasi.')->group(function () {
    Route::get('/', [FrontendPartisipasiController::class, 'index'])->name('index');
    Route::get('/create', [FrontendPartisipasiController::class, 'create'])->name('create');
    Route::post('/', [FrontendPartisipasiController::class, 'store'])->name('store');
    Route::get('/umkm', [PendaftaranController::class, 'createUmkm'])->name('umkm');
    Route::get('/wisata', [PendaftaranController::class, 'createWisata'])->name('wisata');
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian');
});

// Penilaian Website Frontend
Route::prefix('penilaian')->name('penilaian.')->group(function () {
    Route::get('/', [PenilaianController::class, 'index'])->name('index');
    Route::post('/', [PenilaianController::class, 'store'])->name('store');
});

// Pendaftaran
Route::prefix('daftar')->name('pendaftaran.')->group(function () {
    Route::get('/wisata', [PendaftaranController::class, 'createWisata'])->name('wisata.create');
    Route::post('/wisata', [PendaftaranController::class, 'storeWisata'])->name('wisata.store');
    Route::get('/umkm', [PendaftaranController::class, 'createUmkm'])->name('umkm.create');
    Route::post('/umkm', [PendaftaranController::class, 'storeUmkm'])->name('umkm.store');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Persetujuan Reset Password Admin
    Route::prefix('password-reset-requests')->name('password-reset.')->group(function () {
        Route::get('/', [AdminPasswordResetController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [AdminPasswordResetController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminPasswordResetController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminPasswordResetController::class, 'destroy'])->name('destroy');
    });

    // Profil Admin & Pegawai Quick Action
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/pegawai/store', [DashboardController::class, 'storePegawai'])->name('pegawai.store');
    Route::delete('/pegawai/{id}', [DashboardController::class, 'destroyPegawai'])->name('pegawai.destroy');

    // Pengaturan SiteSetting
    Route::get('/pengaturan-site', [DashboardController::class, 'pengaturan'])->name('pengaturan.site');
    Route::post('/pengaturan-site', [DashboardController::class, 'updatePengaturan'])->name('pengaturan.site.update');

    // Tentang KKN
    Route::get('/tentang-kkn', [TentangKknController::class, 'index'])->name('tentang-kkn.index');

    // Emergency Contact
    Route::resource('emergency-contact', EmergencyContactController::class)->except(['create', 'edit', 'show']);
    Route::put('/emergency-contact/{emergencyContact}/toggle', [EmergencyContactController::class, 'toggle'])->name('emergency-contact.toggle');

    // Custom Gallery Delete
    Route::delete('/umkm/gallery/{gallery}', [AdminUmkmController::class, 'deleteGallery'])->name('umkm.gallery.destroy');

    // Konten & Resi / Master Data
    Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita']);
    Route::resource('pengumuman', AdminPengumumanController::class);
    Route::resource('wisata', AdminWisataController::class)->parameters(['wisata' => 'wisata']);
    Route::resource('umkm', AdminUmkmController::class);
    Route::resource('galeri', AdminGaleriController::class)->except(['show', 'edit', 'update']);
    Route::resource('agenda', AdminAgendaController::class)->except(['show']);
    Route::resource('hero-banner', HeroBannerController::class)->except(['show']);

    Route::post('/hero-banner-reorder', [HeroBannerController::class, 'reorder'])->name('hero-banner.reorder');

    // Social Post
    Route::get('/social-post', [SocialPostController::class, 'index'])->name('social-post.index');
    Route::post('/social-post', [SocialPostController::class, 'store'])->name('social-post.store');
    Route::delete('/social-post/{socialPost}', [SocialPostController::class, 'destroy'])->name('social-post.destroy');

    // Multi-photo Gallery Generic
    Route::prefix('gallery/{type}/{id}')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
    });
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Inbox Janji Temu Admin
    Route::resource('janji-temu', AdminJanjiTemuController::class)->only(['index', 'show', 'update', 'destroy']);

    // Anggaran (Admin Management)
    Route::resource('anggaran', AdminAnggaranController::class)->except(['create', 'show']);

    // Inbox Pengaduan Admin (Pastikan export ditaruh di atas resource)
    Route::get('/pengaduan/export/excel', [AdminPengaduanController::class, 'exportExcel'])->name('pengaduan.export.excel');
    Route::get('/pengaduan/export/pdf', [AdminPengaduanController::class, 'exportPdf'])->name('pengaduan.export.pdf');
    Route::resource('pengaduan', AdminPengaduanController::class)->only(['index', 'show', 'update', 'destroy']);

    // Admin Partisipasi Warga
    Route::resource('partisipasi', AdminPartisipasiController::class);

    // Admin Partisipasi UMKM
    Route::prefix('partisipasi-umkm')->name('partisipasi-umkm.')->group(function () {
        Route::get('/', [AdminPartisipasiController::class, 'umkmIndex'])->name('index');
        Route::patch('/{id}/status', [AdminPartisipasiController::class, 'umkmUpdateStatus'])->name('update-status');
        Route::delete('/{id}', [AdminPartisipasiController::class, 'destroy'])->name('destroy');
    });

    // Admin Partisipasi Wisata
    Route::prefix('partisipasi-wisata')->name('partisipasi-wisata.')->group(function () {
        Route::get('/', [AdminPartisipasiController::class, 'wisataIndex'])->name('index');
        Route::patch('/{id}/status', [AdminPartisipasiController::class, 'wisataUpdateStatus'])->name('update-status');
        Route::delete('/{id}', [AdminPartisipasiController::class, 'wisataDestroy'])->name('destroy');
    });

    // Admin Penilaian
    Route::get('/penilaian', [AdminPenilaianController::class, 'index'])->name('penilaian.index');
    Route::delete('/penilaian/{penilaian}', [AdminPenilaianController::class, 'destroy'])->name('penilaian.destroy');

    // Inbox Layanan Surat Admin
    Route::resource('layanan-surat', AdminLayananSuratController::class)->only(['index', 'show', 'update', 'destroy']);

    // Akses Approval Wisata & UMKM
    Route::put('/wisata-approve/{wisata}', [AdminWisataController::class, 'approve'])->name('wisata.approve');
    Route::put('/umkm-approve/{umkm}', [AdminUmkmController::class, 'approve'])->name('umkm.approve');

    // Mark Notified (AJAX)
    Route::post('/pengaduan/{pengaduan}/mark-notified', function (Pengaduan $pengaduan) {
        $pengaduan->update(['notif_terakhir_dikirim' => now()]);
        return response()->json(['success' => true]);
    })->name('pengaduan.mark-notified');

    Route::post('/layanan-surat/{layananSurat}/mark-notified', function (LayananSurat $layananSurat) {
        $layananSurat->update(['notif_terakhir_dikirim' => now()]);
        return response()->json(['success' => true]);
    })->name('layanan-surat.mark-notified');

    // Restricted Area — khusus Super Admin
    Route::middleware('super_admin')->group(function () {
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('users', UserController::class);

        Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');
    });
});
