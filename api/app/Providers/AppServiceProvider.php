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
        $this->app->bind(HomeController::class, function (Application $app) {
            $studentRepository = new StudentRepository();
            $entryRepository = new EntryRepository();
            return new HomeService($entryRepository, $studentRepository);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
