<?php

declare(strict_types=1);

namespace Revolution\Ordering\Providers\Concerns;

use Illuminate\Support\Facades\Route;

trait WithRoutes
{
    protected function configureRoutes()
    {
        if (! config('ordering.routes', true)) {
            return; // @codeCoverageIgnore
        }

        Route::domain(config('ordering.domain'))
             ->prefix(config('ordering.prefix'))
             ->group(function () {
                 Route::middleware(config('ordering.middleware.web', 'web'))
                      ->group(function () {
                          $this->loadRoutesFrom(__DIR__.'/../../../routes/web.php');
                      });

                 Route::middleware(config('ordering.middleware.api', 'api'))
                      ->prefix('api')
                      ->group(function () {
                          $this->loadRoutesFrom(__DIR__.'/../../../routes/api.php');
                      });
             });
    }
}
