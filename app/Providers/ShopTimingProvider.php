<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AvailabilityInterface;
use App\Interfaces\CurrentAvailabilityInterface;
use App\Interfaces\NextAvailabilityInterface;
use App\Services\ShopTimingService;


class ShopTimingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AvailabilityInterface::class, function () {
            return new ShopTimingService();
        });

        $this->app->bind(CurrentAvailabilityInterface::class, function () {
            return new ShopTimingService();
        });

        $this->app->bind(NextAvailabilityInterface::class, function () {
            return new ShopTimingService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
