<?php

namespace App\Providers;

use App\Services\DosenService;
use App\Services\Impl\DosenServiceImpl;
use Illuminate\Support\ServiceProvider;

class DosenServiceProvider extends ServiceProvider
{
    public  array $singletons = [
        DosenService::class => DosenServiceImpl::class
    ];
    public function provides(): array
    {
        return [DosenService::class];
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
