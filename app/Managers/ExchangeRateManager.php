<?php

namespace App\Managers;

use App\Services\ApiExchangeRateService;
use App\Services\LocalExchangeRateService;
use Illuminate\Support\Manager;

class ExchangeRateManager extends Manager
{
    /**
     * Create an instance of the local exchange rate driver.
     *
     * @return \App\Services\LocalExchangeRateService
     */
    protected function createLocalDriver()
    {
        return new LocalExchangeRateService();
    }

    /**
     * Create an instance of the api exchange rate driver.
     *
     * @return \App\Services\ApiExchangeRateService
     */
    protected function createApiDriver()
    {
        return new ApiExchangeRateService();
    }

    /**
     * Get the default exchange rate driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('exchangerate.driver');
    }
}
