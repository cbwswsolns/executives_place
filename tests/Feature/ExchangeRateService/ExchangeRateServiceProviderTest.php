<?php

namespace Tests\Feature\ExchangeRateService;

use App\Managers\ExchangeRateManager;
use App\Services\ApiExchangeRateService;
use App\Services\LocalExchangeRateService;
use App\Providers\ExchangeRateServiceProvider;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ExchangeRateServiceProviderTest extends TestCase
{
    /**
     * This test verifies that this service provider can bind the
     * exchange rate manager to the container
     *
     * @test
     *
     * @return void
     */
    public function canBindExchangeRateManagerToContainer()
    {
        $this->app->forgetInstance('exchangerate');

        (new ExchangeRateServiceProvider($this->app))->register();

        $this->assertInstanceOf(
            ExchangeRateManager::class,
            $this->app['exchangerate']
        );
    }


    /**
     * This test verifies that this service provider can bind the
     * local exchange rate driver to the container
     *
     * @test
     *
     * @return void
     */
    public function canBindLocalExchangeRateDriverToContainer()
    {
        Config::set('exchangerate.driver', 'local');

        // Remove/unbind instance from container
        unset($this->app['exchangerate.driver']);

        // Re-register exchangerate.driver
        (new ExchangeRateServiceProvider($this->app))->register();

        // Verify new binding
        $this->assertInstanceOf(
            LocalExchangeRateService::class,
            $this->app['exchangerate.driver']
        );
    }


    /**
     * This test verifies that this service provider can bind the
     * api exchange rate driver to the container
     *
     * @test
     *
     * @return void
     */
    public function canBindApiExchangeRateDriverToContainer()
    {
        Config::set('exchangerate.driver', 'api');

        // Remove/unbind instance from container
        unset($this->app['exchangerate.driver']);

        // Re-register exchangerate.driver
        (new ExchangeRateServiceProvider($this->app))->register();

        // Verify new binding
        $this->assertInstanceOf(
            ApiExchangeRateService::class,
            $this->app['exchangerate.driver']
        );
    }
}
