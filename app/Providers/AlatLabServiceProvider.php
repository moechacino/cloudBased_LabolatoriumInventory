<?php

namespace App\Providers;

use App\Services\AlatLabService;
use App\Services\Impl\AlatLabServiceImpl;
use Illuminate\Support\ServiceProvider;

class AlatLabServiceProvider extends ServiceProvider
{
    public  array $singletons = [
        AlatLabService::class => AlatLabServiceImpl::class
    ];
    public function provides(): array
    {
        return [AlatLabService::class];
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
