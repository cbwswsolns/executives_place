<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array fetchRates(string $baseCurrency);
 *
 * @see \App\Managers\ExchangeRateManager
 * @see \App\Contracts\ExchangeRateInterface
 */
class ExchangeRate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'exchangerate.driver';
    }
}
