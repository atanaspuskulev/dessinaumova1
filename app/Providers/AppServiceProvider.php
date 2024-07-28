<?php

namespace App\Providers;

use App\Http\View\Composers\CartCurrentContentComposer;
use App\Http\View\Composers\CartItemsComposer;
use App\Http\View\Composers\CategoriesComposer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

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
        Paginator::useBootstrapFour();
        Schema::defaultStringLength(191); // Do not remove this on shared hosting
        Model::preventAccessingMissingAttributes(!$this->app->isProduction());
        Model::preventLazyLoading(!$this->app->isProduction());
        View::composer(['front.products', 'front.product_view'], CartCurrentContentComposer::class);
        View::composer(['layouts.front'], CategoriesComposer::class);
        View::composer(['layouts.front'], CartItemsComposer::class);
    }
}
