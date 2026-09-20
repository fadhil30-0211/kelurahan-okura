<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
        // Menggunakan View::composer untuk layout frontend agar data selalu tersedia
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

            // --- PERHITUNGAN JUMLAH PENGUNJUNG / VIEW COUNTER ---
            $totalViews = 0;
            $todayViews = 0;

            if (Schema::hasTable('page_views')) {
                // Jika kamu memiliki tabel `page_views`
                $totalViews = DB::table('page_views')->count();$todayViews = DB::table('page_views')
                    ->whereDate('created_at', Carbon::today())
                    ->count();
            } else {
                // Nilai dummy/default jika tabel durung ada (bisa disesuaikan angkanya)
                $totalViews = 1250;
                $todayViews = 42;
            }

            // Kirim variabel ke view
            $view->with([
                'settings'          => $siteSetting,
                'siteSetting'       => $siteSetting,
                'emergencyContacts' => $emergencyContacts,
                'pengumumanDarurat' => $pengumumanDarurat,
                'totalViews'        => $totalViews,
                'todayViews'        => $todayViews,
            ]);
        });
    }
}
