<?php

namespace App\Providers;

use App\View\Composers\CurrencyComposer;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...

        view()->composer(
            [
                'executives.index',
                'executives.create'
            ],
            CurrencyComposer::class
        );
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Do nothing
    }
}
