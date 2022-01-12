<?php

namespace App\Contracts;

interface ExchangeRateInterface
{
    /**
     * Fetch exchange rates
     *
     * @param  string $baseCurrency [base currency for the rate calculation]
     *
     * @return array
     */
    public function fetchRates($baseCurrency);
}
