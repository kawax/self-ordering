<?php

namespace Revolution\Ordering\Providers\Concerns;

use Illuminate\Support\Facades\Route;

trait WithRoutes
{
    protected function configureRoutes()
    {
        if (! config('ordering.routes', true)) {
            return; // @codeCoverageIgnore
        }

        Route::middleware(config('ordering.middleware', 'web'))
             ->domain(config('ordering.domain'))
             ->prefix(config('ordering.prefix'))
             ->group(function () {
                 $this->loadRoutesFrom(__DIR__.'/../../../routes/web.php');
             });
    }
}
