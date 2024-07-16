<?php

namespace App\Providers;

use App\Services\Impl\PeminjamanMahasiswaServiceImpl;
use App\Services\PeminjamanMahasiswaService;
use Illuminate\Support\ServiceProvider;

class PeminjamanMahasiswaServiceProvider extends ServiceProvider
{
    public  array $singletons = [
        PeminjamanMahasiswaService::class => PeminjamanMahasiswaServiceImpl::class
    ];
    public function provides(): array
    {
        return [PeminjamanMahasiswaService::class];
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
