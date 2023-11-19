<?php

namespace App\Providers;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        // 自作ファサードを取得
        $facades = config('app.aliases');
        $defaultFacades = Facade::defaultAliases()->toArray();
        $originalFacades = array_diff($facades, $defaultFacades);

        // 自作ファサードとUtil関数を紐付ける
        foreach ($originalFacades as $alias => $facade) {
            $facade = str_replace("App\\Facades\\", '', $facade);
            $utilClass = "\\App\\Utils\\".$facade;
            $this->app->singleton($alias, $utilClass);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
