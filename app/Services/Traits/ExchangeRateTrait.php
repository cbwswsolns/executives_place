<?php

namespace App\Services\Traits;

use InvalidArgumentException;

trait ExchangeRateTrait
{
    /**
     * Convert from base currency amount to the target currency amount
     * using given exchange rate (provided the inputs are both numeric)
     *
     * Otherwise, throw an invalid argument exception
     *
     * @param  mixed $baseCurrencyAmount [base currency amount to convert]
     * @param  mixed $rate               [exchange rate used for conversion]
     *
     * @return float [target currency amount]
     */
    public static function convertCurrency($baseCurrencyAmount, $rate)
    {
        if ((is_numeric($baseCurrencyAmount) && is_numeric($rate))) {
            return round((float)$baseCurrencyAmount * (float)$rate, 2);
        } else {
            throw new InvalidArgumentException("Arguments must both have numeric values");
        }
    }
}
