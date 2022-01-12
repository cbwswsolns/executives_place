<?php

namespace App\View\Composers;

use Illuminate\View\View;

class CurrencyComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view [the view instance]
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currencies', config('exchangerate.allowed_currencies'));
    }
}
