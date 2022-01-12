<?php

namespace Tests\Feature\ExchangeRateService;

use App\Services\LocalExchangeRateService;
use Tests\TestCase;

class LocalExchangeRateServiceTest extends TestCase
{
    /**
     * Exchange rate service instance
     *
     * @var App\Services\LocalExchangeRateService
     */
    protected $exchangeRateService;


    /**
     * Set up test class
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->exchangeRateService =
            $this->app->make('App\Services\LocalExchangeRateService');
    }

    /**
     * Verify expected exchange rates returned for GBP base currency
     *
     * @test
     *
     * @return void
     */
    public function checkExpectedExchangeRatesForGBP()
    {
        $rates = $this->exchangeRateService->fetchRates('GBP');

        $this->assertEquals(['GBP' => 1, 'USD' => 1.3, 'EUR' => 1.1], $rates);
    }


    /**
     * Verify expected exchange rates returned for EUR base currency
     *
     * @test
     *
     * @return void
     */
    public function checkExpectedExchangeRatesForEUR()
    {
        $rates = $this->exchangeRateService->fetchRates('EUR');

        $this->assertEquals(['EUR' => 1, 'GBP' => 0.9, 'USD' => 1.2], $rates);
    }


    /**
     * Verify expected exchange rates returned for for USD base currency
     *
     * @test
     *
     * @return void
     */
    public function checkExpectedExchangeRatesForUSD()
    {
        $rates = $this->exchangeRateService->fetchRates('USD');

        $this->assertEquals(['USD' => 1, 'GBP' => 0.7, 'EUR' => 0.8], $rates);
    }
}
