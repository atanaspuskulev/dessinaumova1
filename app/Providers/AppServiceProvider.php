<?php

namespace App\Providers;

use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use App\Http\Services\SessionStorageService;
use App\Http\View\Composers\CartCurrentContentComposer;
use App\Http\View\Composers\CartItemsComposer;
use App\Http\View\Composers\CategoriesComposer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
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
        $this->app->bind(OrderService::class, function($app) {
            return new OrderService(
                $app->make(SessionStorageService::class),
                $app->make(CartService::class)
            );
        });
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

        Blade::directive('shipping_cost', static function ($shippingCost) {
            return "<?php echo \App\Directives\ShippingCostDirective::shippingCostLabel($shippingCost); ?>";
        });

        Blade::directive('price', function($params) {
            return "<?php echo \App\Directives\DisplayPriceDirective::displayPrice($params); ?>";
        });
    }
}
