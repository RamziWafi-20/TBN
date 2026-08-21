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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan folder runtime Laravel tersedia saat pertama kali dijalankan.
        foreach ([
            storage_path('framework/views'),
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ] as $directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }
}
