<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $seller_namespace = 'App\Http\Controllers\Seller';
    public const SELLER_LOGIN = '/seller/login';
    /* api */
    protected $customerapi_namespace = 'App\Http\Controllers\Api\Customer';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapSellerRoutes();
        $this->mapApiRoutes();
        $this->mapCustomerApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));
    }

    protected function mapSellerRoutes()
    {
        Route::middleware('web')
        ->namespace($this->seller_namespace)
        ->group(base_path('routes/seller.php'));
    }

    protected function mapCustomerApiRoutes()
    {
        Route::prefix('api')
        ->middleware('api')
        ->namespace($this->customerapi_namespace)
        ->group(base_path('routes/customerapi.php'));
    }
}
