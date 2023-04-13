<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Categories;
use App\Models\Discount;
use App\Models\Introduce;
use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\Suppliers;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 0); ?>";
        });
        Relation::enforceMorphMap([
            1 => Products::class,
            5 => Brand::class,
            2 => ProductDetail::class,
            3 => Type::class,
            4 => Categories::class,
            6 => User::class,
            7 => Discount::class,
            8 => Introduce::class,
            9 => Suppliers::class
        ]);
        Paginator::useBootstrap();
    }
}
