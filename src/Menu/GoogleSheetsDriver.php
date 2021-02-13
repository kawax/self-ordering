<?php

namespace Revolution\Ordering\Menu;

use Google_Service_Sheets_Resource_SpreadsheetsValues as SpreadsheetsValues;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Menu\MenuDriver;

class GoogleSheetsDriver implements MenuDriver
{
    use Macroable;

    /**
     * @inheritDoc
     */
    public function get()
    {
        /**
         * @var SpreadsheetsValues $sheets
         */
        $sheets = app('ordering.google.sheets.values');

        $values = Collection::wrap($sheets->get(
            config('ordering.menu.google-sheets.spreadsheets'),
            config('ordering.menu.google-sheets.menus_sheet')
        )->getValues());

        $header = $values->pull(0);

        return $values->map(function ($item) use ($header) {
            $row = Collection::wrap($item)->pad(count($header), null);

            return collect($header)->combine($row)->toArray();
        })->values();
    }
}
