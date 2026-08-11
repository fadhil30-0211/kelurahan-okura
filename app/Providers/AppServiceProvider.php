<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EmergencyContact;
use App\Models\Pengumuman;

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
        View::composer('layouts.frontend', function ($view) {
            $view->with('emergencyContacts', EmergencyContact::active()->get());
            $view->with('pengumumanDarurat', Pengumuman::active()->where('kategori', 'darurat')->latest()->first());
        });
    }
}
