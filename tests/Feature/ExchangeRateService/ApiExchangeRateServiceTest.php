<?php

namespace Tests\Feature\ExchangeRateService;

use App\Services\ApiExchangeRateService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiExchangeRateServiceTest extends TestCase
{
    /**
     * Exchange rate service instance
     *
     * @var App\Services\ApiExchangeRateService
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
            $this->app->make('App\Services\ApiExchangeRateService');
    }


    /**
     * Verify expected exchange rates returned for GBP base currency
     * Mocked external API request and response
     *
     * @test
     *
     * @return void
     */
    public function checkExpectedExchangeRatesForGBP()
    {
        // Mock response from external Free Currency API
        Http::fake([
            'https://freecurrencyapi.net/api/v2*' => Http::response([
                'data' => [
                    'GBP' => 1,
                    'EUR' => 1.125,
                    'USD' => 1.345
                ],
            ], 200)
        ]);

        //$ApiExchangeRateService = new ApiExchangeRateService();

        $baseCurrency = 'GBP';

        $rates = $this->exchangeRateService->fetchRates($baseCurrency);

        // Verify URL of faked request
        Http::assertSent(function ($request) use ($baseCurrency) {
            return ($request->url() == 'https://freecurrencyapi.net/api/v2/latest?apikey=' . config('exchangerate.api_key') . '&base_currency=' . $baseCurrency);
        });

        $this->assertIsArray($rates);

        $this->assertEquals([
            'GBP' => 1,
            'EUR' => 1.125,
            'USD' => 1.345
        ], $rates);
    }


    /**
     * Verify expected exchange rates returned for EUR base currency
     * Mocked external API request and response
     *
     * @test
     *
     * @return void
     */
    public function checkExpectedExchangeRatesForEUR()
    {
        // Mock response from external Free Currency API
        Http::fake([
            'https://freecurrencyapi.net/api/v2*' => Http::response([
                'data' => [
                    'GBP' => 0.915,
                    'EUR' => 1,
                    'USD' => 1.234
                ],
            ], 200)
        ]);

        $baseCurrency = 'EUR';

        $rates = $this->exchangeRateService->fetchRates($baseCurrency);

        // Verify URL of faked request
        Http::assertSent(function ($request) use ($baseCurrency) {
            return ($request->url() == 'https://freecurrencyapi.net/api/v2/latest?apikey=' . config('exchangerate.api_key') . '&base_currency=' . $baseCurrency);
        });

        $this->assertIsArray($rates);

        $this->assertEquals([
            'GBP' => 0.915,
            'EUR' => 1,
            'USD' => 1.234
        ], $rates);
    }


    /**
     * Verify expected exchange rates returned for USD base currency
     * Mocked external API request and response
     *
     * @test
     *
     * @return void
     */
    public function checkExpectedExchangeRatesForUSD()
    {
        // Mock response from external Free Currency API
        Http::fake([
            'https://freecurrencyapi.net/api/v2*' => Http::response([
                'data' => [
                    'GBP' => 0.725,
                    'EUR' => 0.834,
                    'USD' => 1
                ],
            ], 200)
        ]);

        $baseCurrency = 'USD';

        $rates = $this->exchangeRateService->fetchRates($baseCurrency);

        // Verify URL of faked request
        Http::assertSent(function ($request) use ($baseCurrency) {
            return ($request->url() == 'https://freecurrencyapi.net/api/v2/latest?apikey=' . config('exchangerate.api_key') . '&base_currency=' . $baseCurrency);
        });

        $this->assertIsArray($rates);

        $this->assertEquals([
            'GBP' => 0.725,
            'EUR' => 0.834,
            'USD' => 1
        ], $rates);
    }
}
