<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Disable Vite errors
        Vite::useManifestFilename('non-existent-manifest.json');
    }
}