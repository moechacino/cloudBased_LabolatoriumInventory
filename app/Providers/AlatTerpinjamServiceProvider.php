<?php

namespace App\Providers;

use App\Services\AlatTerpinjamService;
use App\Services\Impl\AlatTerpinjamServiceImpl;
use Illuminate\Support\ServiceProvider;

class AlatTerpinjamServiceProvider extends ServiceProvider
{
    public  array $singletons = [
        AlatTerpinjamService::class => AlatTerpinjamServiceImpl::class
    ];
    public function provides(): array
    {
        return [AlatTerpinjamService::class];
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
