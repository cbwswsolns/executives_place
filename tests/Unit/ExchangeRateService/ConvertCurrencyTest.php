<?php

namespace Tests\Unit;

use InvalidArgumentException;
use App\Services\Traits\ExchangeRateTrait;
use PHPUnit\Framework\TestCase;

class ConvertCurrencyTest extends TestCase
{
    use ExchangeRateTrait;

    /**
     * Verify return value of currency converter:
     * - inputs: both float
     * - expected return type: float (rounded to 2 decimal places)
     *
     * @test
     *
     * @return void
     */
    public function checkBothInputFloat()
    {
        $convertedAmount = $this->convertCurrency(
            $baseCurrencyAmount = (float)'11.24',
            $rate = (float)1.376
        );
        
        // Verifies same value and type
        $this->assertTrue($convertedAmount === (float)15.47);
    }


    /**
     * Verify return value of currency converter:
     * - inputs: both string
     * - expected return type: float (rounded to 2 decimal places)
     *
     * @test
     *
     * @return void
     */
    public function checkBothInputString()
    {
        $convertedAmount = $this->convertCurrency(
            $baseCurrencyAmount = '11.24',
            $rate = '1.376'
        );
        
        $this->assertTrue($convertedAmount === (float)15.47);
    }


    /**
     * Verify currency converter raises exception for non numerical
     * base currency ammount
     *
     * @test
     *
     * @return void
     */
    public function checkExceptionNonNumericBaseCurrencyArg()
    {
        $this->expectException(InvalidArgumentException::class);

        $convertedAmount = $this->convertCurrency(
            $baseCurrencyAmount = 'ABC',
            $rate = '1.376'
        );
    }


    /**
     * Verify currency converter raises exception for non numerical
     * rate amount
     *
     * @test
     *
     * @return void
     */
    public function checkExceptionNonNumericRateArg()
    {
        $this->expectException(InvalidArgumentException::class);

        $convertedAmount = $this->convertCurrency(
            $baseCurrencyAmount = '11.24',
            $rate = 'DAR'
        );
    }


    /**
     * Verify currency converter raises exception for both non-numeric
     * base currency amount and non-numeric rate amount
     *
     * @test
     *
     * @return void
     */
    public function checkExceptionBothNonNumericArgs()
    {
        $this->expectException(InvalidArgumentException::class);

        $convertedAmount = $this->convertCurrency(
            $baseCurrencyAmount = 'ABC',
            $rate = 'EFG'
        );
    }
}
