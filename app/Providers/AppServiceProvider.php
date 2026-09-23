<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if (file_exists(app_path('Helper/helpers.php'))) {
            require_once app_path('Helper/helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tambahkan baris kode di bawah ini untuk Vercel:
        if (config('app.env') === 'production') {
            $array = [
                '/tmp/storage/framework/views',
                '/tmp/storage/framework/cache',
                '/tmp/storage/framework/sessions'
            ];
            foreach ($array as $path) {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
            }
        }
    } // <-- Kurung kurawal penutup untuk fungsi boot()
} // <-- Kurung kurawal penutup untuk class AppServiceProvider
