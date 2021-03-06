<?php

namespace App\Providers;

use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\IBannerRepository;
use App\Repositories\Contracts\ICategoryRepository;
use App\Repositories\Contracts\ICouponRepository;
use App\Repositories\Contracts\IImageRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\IReportUserRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\CouponRepository;
use App\Repositories\ImageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReportUserRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(IImageRepository::class,ImageRepository::class);
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IReportUserRepository::class,ReportUserRepository::class);
    }
}
