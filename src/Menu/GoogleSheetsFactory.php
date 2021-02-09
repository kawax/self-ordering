<?php

namespace Revolution\Ordering\Menu;

use Google\Client;
use Google_Service_Sheets;

class GoogleSheetsFactory
{
    /**
     * @return Google_Service_Sheets
     */
    public function __invoke(): Google_Service_Sheets
    {
        return new Google_Service_Sheets(
            tap(new Client())->setDeveloperKey(config('ordering.menu.google-sheets.api_key'))
        );
    }
}
