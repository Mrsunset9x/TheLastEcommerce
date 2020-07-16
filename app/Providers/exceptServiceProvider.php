<?php

namespace App\Providers;

use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\IBannerRepository;
use App\Repositories\Contracts\ICategoryRepository;
use App\Repositories\Contracts\ICouponRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class exceptServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IBannerRepository::class,BannerRepository::class);
        $this->app->bind(ICategoryRepository::class,CategoryRepository::class);
        $this->app->bind(ICouponRepository::class,CouponRepository::class);
        $this->app->bind(IProductRepository::class,ProductRepository::class);
        $this->app->bind(IOrderRepository::class,OrderRepository::class);
    }
}
