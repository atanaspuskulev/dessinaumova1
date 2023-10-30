<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        Schema::defaultStringLength(191); // Do not remove this on shared hosting
        Model::preventAccessingMissingAttributes(!$this->app->isProduction());
        Model::preventLazyLoading(!$this->app->isProduction());
    }
}
