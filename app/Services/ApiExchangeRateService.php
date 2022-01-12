<?php

namespace App\Services;

use App\Contracts\ExchangeRateInterface;
use App\Services\Traits\ExchangeRateTrait as ExchangeRateTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ApiExchangeRateService implements ExchangeRateInterface
{
    use ExchangeRateTrait;
    
    /**
     * The API key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Construct instance of exchange rate service
     *
     * @return void
     */
    public function __construct()
    {
        $this->apiKey = $this->getApiKey();
    }

    /**
     * Fetch exchange rates for a given base currency
     *
     * @param  string $baseCurrency [base currency used to fetch rates]
     *
     * @return array
     */
    public function fetchRates($baseCurrency)
    {
        $response = Http::get('https://freecurrencyapi.net/api/v2/latest?apikey=' . $this->apiKey . '&base_currency=' . $baseCurrency);

        $rates = $response['data'];

        if (!in_array($baseCurrency, $rates)) {
            $rates = array_merge($rates, [$baseCurrency => 1]);
        }

        return $rates;
    }

    /**
     * Get API key
     *
     * @return string
     */
    protected function getApiKey()
    {
        return config('exchangerate.api_key');
    }
}
