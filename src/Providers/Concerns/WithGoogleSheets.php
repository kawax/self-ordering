<?php

declare(strict_types=1);

namespace Revolution\Ordering\Providers\Concerns;

use Revolution\Ordering\Menu\GoogleSheetsFactory;

trait WithGoogleSheets
{
    protected function registerGoogle(): void
    {
        $this->app->singleton(
            'ordering.google.sheets',
            fn ($app) => $app->make(GoogleSheetsFactory::class)()
        );

        $this->app->singleton(
            'ordering.google.sheets.values',
            fn ($app) => $app->make('ordering.google.sheets')->spreadsheets_values
        );
    }
}
