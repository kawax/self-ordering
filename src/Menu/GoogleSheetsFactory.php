<?php

declare(strict_types=1);

namespace Revolution\Ordering\Menu;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetsFactory
{
    /**
     * @return Sheets
     */
    public function __invoke(): Sheets
    {
        return new Sheets(
            tap(new Client())->setDeveloperKey(config('ordering.menu.google-sheets.api_key'))
        );
    }
}
