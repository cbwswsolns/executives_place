<?php

namespace Tests\Feature\ExchangeRateService;

use App\Managers\ExchangeRateManager;
use App\Services\ApiExchangeRateService;
use App\Services\LocalExchangeRateService;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ExchangeRateManagerTest extends TestCase
{
    /**
     * Exchange rate manager instance
     *
     * @var App\Managers\ExchangeRateManager
     */
    protected $exchangeRateManager;


    /**
     * Set up test class
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->exchangeRateManager =
            $this->app->makeWith(
                'App\Managers\ExchangeRateManager',
                [$this->app]
            );
    }


    /**
     * Verify manager gets local exchange rate driver string when
     * local driver is configured as default
     *
     * @test
     *
     * @return void
     */
    public function getsLocalDriverWhenConfigured()
    {
        Config::set('exchangerate.driver', 'local');

        $driverString = $this->exchangeRateManager->getDefaultDriver();

        $this->assertEquals('local', $driverString);
    }


    /**
     * Verify manager gets api exchange rate driver string when
     * local driver is configured as default
     *
     * @test
     *
     * @return void
     */
    public function getsApiDriverWhenConfigured()
    {
        Config::set('exchangerate.driver', 'api');

        $driverString = $this->exchangeRateManager->getDefaultDriver();

        $this->assertEquals('api', $driverString);
    }

    /**
     * Verify manager invokes the routine to create local driver instance
     * based on selecting local default driver
     *
     * @test
     *
     * @return void
     */
    public function testInvocationOfCreateLocalDriver()
    {
        Config::set('exchangerate.driver', 'local');

        $this->exchangeRateManager->forgetDrivers();

        $this->exchangeRateManager->driver();

        $drivers = $this->exchangeRateManager->getDrivers();

        $this->assertInstanceOf(
            LocalExchangeRateService::class,
            $drivers['local']
        );
    }

    /**
     * Verify manager invokes the routine to create api driver instance
     * based on selecting API default driver
     *
     * @test
     *
     * @return void
     */
    public function testInvocationOfCreateApiDriver()
    {
        Config::set('exchangerate.driver', 'api');

        $this->exchangeRateManager->forgetDrivers();

        $this->exchangeRateManager->driver();

        $drivers = $this->exchangeRateManager->getDrivers();

        $this->assertInstanceOf(
            ApiExchangeRateService::class,
            $drivers['api']
        );
    }
}
