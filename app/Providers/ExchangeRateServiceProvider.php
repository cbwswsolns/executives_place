<?php

namespace App\Providers;

use App\Managers\ExchangeRateManager;
use Illuminate\Support\ServiceProvider;

class ExchangeRateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerExchangeRateManager();

        $this->registerExchangeRateDriver();
    }


    /**
     * Register the exchange rate manager instance.
     *
     * @return void
     */
    protected function registerExchangeRateManager()
    {
        $this->app->singleton('exchangerate', function ($app) {
            return new ExchangeRateManager($app);
        });
    }


    /**
     * Register the exchange rate driver instance.
     *
     * @return void
     */
    protected function registerExchangeRateDriver()
    {
        $this->app->singleton('exchangerate.driver', function ($app) {
            return $app->make('exchangerate')->driver();
        });
    }
}
