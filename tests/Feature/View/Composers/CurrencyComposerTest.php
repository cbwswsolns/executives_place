<?php

namespace Tests\Feature\View\Composers;

use App\View\Composers\CurrencyComposer;
use Illuminate\View\View;
use Mockery\MockInterface;
use Tests\TestCase;

class CurrencyComposerTest extends TestCase
{
    /**
     * Verify composer passes currencies collection to view
     *
     * @test
     *
     * @return void
     */
    public function currenciesPassedToView()
    {
        $currencyComposer = new CurrencyComposer();

        $mockView =
            $this->mock(View::class, function (MockInterface $mockView) {
                $currencies = config('exchangerate.allowed_currencies');

                $mockView->shouldReceive('with')
                         ->with('currencies', $currencies)
                         ->once();
            });

        $currencyComposer->compose($mockView);
    }

    /**
     * Verify data injected into executive listing view
     *
     * @test
     *
     * @return void
     */
    public function verifyExecutiveListingViewHasCurrencies()
    {
        $response = $this->get('/users');

        $response->assertViewHas('currencies');
    }


    /**
     * Verify data injected into executive listing view
     *
     * @test
     *
     * @return void
     */
    public function verifyExecutiveCreateViewHasCurrencies()
    {
        $response = $this->get('/users/create');

        $response->assertViewHas('currencies');
    }
}
