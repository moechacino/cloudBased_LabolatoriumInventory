<?php

namespace App\Providers;

use App\Services\AdminService;
use App\Services\Impl\AdminServiceImpl;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
   public  array $singletons = [
      AdminService::class => AdminServiceImpl::class
   ];
    public function provides(): array
    {
        return [AdminService::class];
    }
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
