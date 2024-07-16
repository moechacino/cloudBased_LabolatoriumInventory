<?php

namespace App\Providers;

use App\Services\Impl\PeminjamanDosenServiceImpl;
use App\Services\PeminjamanDosenService;
use Illuminate\Support\ServiceProvider;

class PeminjamanDosenServiceProvider extends ServiceProvider
{
    public  array $singletons = [
        PeminjamanDosenService::class => PeminjamanDosenServiceImpl::class
    ];
    public function provides(): array
    {
        return [PeminjamanDosenService::class];
    }
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
