<?php

namespace App\Providers;

use App\Http\Controllers\HomeController;
use App\Repositories\EntryRepository;
use App\Repositories\StudentRepository;
use App\Services\HomeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
