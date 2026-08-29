<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\EmergencyContact;
use App\Models\Pengumuman;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menggunakan View::composer untuk layout frontend agar data darurat & setting selalu tersedia
        View::composer(['layouts.frontend', 'frontend.*'], function ($view) {
            // Ambil data setting aman dari error jika tabel belum ada / kosong
            $siteSetting = null;
            if (Schema::hasTable('settings')) {
                $siteSetting = Setting::first();
            }

            // Ambil kontak darurat yang aktif
            $emergencyContacts = collect();
            if (Schema::hasTable('emergency_contacts')) {
                $emergencyContacts = EmergencyContact::active()->get();
            }

            // Ambil pengumuman darurat aktif terbaru
            $pengumumanDarurat = null;
            if (Schema::hasTable('pengumumans')) {
                $pengumumanDarurat = Pengumuman::active()->where('kategori', 'darurat')->latest()->first();
            }

            // Kirim variabel ke view (menyediakan $settings & $siteSetting sekaligus agar kompatibel)
            $view->with([
                'settings'          => $siteSetting,
                'siteSetting'       => $siteSetting,
                'emergencyContacts' => $emergencyContacts,
                'pengumumanDarurat' => $pengumumanDarurat,
            ]);
        });
    }
}
