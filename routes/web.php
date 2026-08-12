<?php

use Illuminate\Support\Facades\Route;

// Import Controllers - Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\WisataController;
use App\Http\Controllers\Frontend\UmkmController;
use App\Http\Controllers\Frontend\BeritaController as FrontendBeritaController;
use App\Http\Controllers\Frontend\PengaduanController;
use App\Http\Controllers\Frontend\LayananSuratController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\JanjiTemuController;
use App\Http\Controllers\Frontend\ResiController;
use App\Http\Controllers\Frontend\UniversalTrackingController;
use App\Http\Controllers\Frontend\PendaftaranController;
use App\Http\Controllers\Frontend\PengumumanController as FrontendPengumumanController;
use App\Http\Controllers\Frontend\GaleriController as FrontendGaleriController;
use App\Http\Controllers\Frontend\AgendaController as FrontendAgendaController;
use App\Http\Controllers\Frontend\SurveiKepuasanController as FrontendSurveiKepuasanController;

// Import Controllers - Auth
use App\Http\Controllers\Auth\LoginController;

// Import Controllers - Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\WisataController as AdminWisataController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\LayananSuratController as AdminLayananSuratController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\SurveiKepuasanController;
use App\Http\Controllers\Admin\EmergencyContactController;
use App\Http\Controllers\Admin\SocialPostController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// Home & General
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/cari', [SearchController::class, 'index'])->name('search');

// Pengumuman
Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
    Route::get('/', [FrontendPengumumanController::class, 'index'])->name('index');
    Route::get('/{pengumuman}', [FrontendPengumumanController::class, 'show'])->name('show');
});

// Galeri & Agenda
Route::get('/galeri', [FrontendGaleriController::class, 'index'])->name('galeri.index');
Route::get('/agenda', [FrontendAgendaController::class, 'index'])->name('agenda.index');

// Janji Temu
Route::get('/janji-temu', [JanjiTemuController::class, 'create'])->name('janji-temu.create');
Route::post('/janji-temu', [JanjiTemuController::class, 'store'])->name('janji-temu.store');

// Resi & Tracking
Route::get('/resi/{kodeTiket}', [ResiController::class, 'show'])->name('resi.show');
Route::get('/resi/{kodeTiket}/download', [ResiController::class, 'download'])->name('resi.download');
Route::post('/lacak', [UniversalTrackingController::class, 'track'])->name('tracking.universal');

// Wisata
Route::prefix('wisata')->name('wisata.')->group(function () {
    Route::get('/', [WisataController::class, 'index'])->name('index');
    Route::get('/{slug}', [WisataController::class, 'show'])->name('show');
});

// UMKM
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('index');
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

// Pengaduan
Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
    Route::get('/', [PengaduanController::class, 'create'])->name('create');
    Route::post('/', [PengaduanController::class, 'store'])->name('store');
    Route::get('/lacak', [PengaduanController::class, 'trackForm'])->name('track.form');
    Route::post('/lacak', [PengaduanController::class, 'track'])->name('track');
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
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Emergency Contact
    Route::resource('emergency-contact', EmergencyContactController::class)->except(['create', 'edit', 'show']);
    Route::put('/emergency-contact/{emergencyContact}/toggle', [EmergencyContactController::class, 'toggle'])->name('emergency-contact.toggle');

    // Konten harian
    Route::resource('berita', BeritaController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('wisata', AdminWisataController::class);
    Route::resource('umkm', AdminUmkmController::class);
    Route::resource('galeri', GaleriController::class)->except(['show', 'edit', 'update']);
    Route::resource('agenda', AgendaController::class)->except(['show']);
    Route::resource('hero-banner', HeroBannerController::class)->except(['show']);
    Route::post('/hero-banner-reorder', [HeroBannerController::class, 'reorder'])->name('hero-banner.reorder');

    // Social Post
    Route::get('/social-post', [SocialPostController::class, 'index'])->name('social-post.index');
    Route::post('/social-post', [SocialPostController::class, 'store'])->name('social-post.store');
    Route::delete('/social-post/{socialPost}', [SocialPostController::class, 'destroy'])->name('social-post.destroy');

    // Multi-photo Gallery
    Route::prefix('gallery/{type}/{id}')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
    });
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Anggaran
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
    Route::post('/anggaran', [AnggaranController::class, 'store'])->name('anggaran.store');
    Route::delete('/anggaran/{anggaran}', [AnggaranController::class, 'destroy'])->name('anggaran.destroy');

    // Inbox Pengaduan & Layanan Surat
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan-export/excel', [AdminPengaduanController::class, 'exportExcel'])->name('pengaduan.export.excel');
    Route::get('/pengaduan-export/pdf', [AdminPengaduanController::class, 'exportPdf'])->name('pengaduan.export.pdf');

    Route::get('/layanan-surat', [AdminLayananSuratController::class, 'index'])->name('layanan-surat.index');
    Route::get('/layanan-surat/{layananSurat}', [AdminLayananSuratController::class, 'show'])->name('layanan-surat.show');

    // Akses UPDATE / Approval
    Route::put('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'update'])->name('pengaduan.update');
    Route::put('/layanan-surat/{layananSurat}', [AdminLayananSuratController::class, 'update'])->name('layanan-surat.update');
    Route::put('/wisata-approve/{wisata}', [AdminWisataController::class, 'approve'])->name('wisata.approve');
    Route::put('/umkm-approve/{umkm}', [AdminUmkmController::class, 'approve'])->name('umkm.approve');

    // Mark Notified (AJAX)
    Route::post('/pengaduan/{pengaduan}/mark-notified', function (\App\Models\Pengaduan $pengaduan) {
        $pengaduan->update(['notif_terakhir_dikirim' => now()]);
        return response()->json(['success' => true]);
    })->name('pengaduan.mark-notified');

    Route::post('/layanan-surat/{layananSurat}/mark-notified', function (\App\Models\LayananSurat $layananSurat) {
        $layananSurat->update(['notif_terakhir_dikirim' => now()]);
        return response()->json(['success' => true]);
    })->name('layanan-surat.mark-notified');

    // Survei Kepuasan
    Route::get('/survei-kepuasan', [SurveiKepuasanController::class, 'index'])->name('survei.index');
    Route::post('/survei-kepuasan', [FrontendSurveiKepuasanController::class, 'store'])->name('survei.store');

    // Data sensitif — khusus super_admin
    Route::middleware('super_admin')->group(function () {
        Route::resource('pegawai', PegawaiController::class);
    });
});
