<?php

namespace App\Services;

use App\Contracts\ExchangeRateInterface;
use App\Services\Traits\ExchangeRateTrait as ExchangeRateTrait;

class LocalExchangeRateService implements ExchangeRateInterface
{
    use ExchangeRateTrait;
    
    // Exchange rate look up table
    protected const EXCHANGE_RATE_LUT = [
        'GBP' => ['GBP' => 1, 'USD' => 1.3, 'EUR' => 1.1],
        'EUR' => ['EUR' => 1, 'GBP' => 0.9, 'USD' => 1.2],
        'USD' => ['USD' => 1, 'GBP' => 0.7, 'EUR' => 0.8]
    ];

    /**
     * Fetch exchange rates for a given base currency
     *
     * @param  string $baseCurrency [base currency used to fetch rates]
     *
     * @return  array
     */
    public function fetchRates($baseCurrency)
    {
        return self::EXCHANGE_RATE_LUT[$baseCurrency];
    }

    /**
     * Get the exchange rate look up table defined for this driver
     *
     * @return  array
     */
    public function getExchangeRateLUT()
    {
        return self::EXCHANGE_RATE_LUT;
    }
}
