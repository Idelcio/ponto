<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // App\Providers\AppServiceProvider.php

    public function register()
    {
        $this->app->bind('files', function () {
            return new \Illuminate\Filesystem\Filesystem();
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
