<?php

namespace Revolution\Ordering\Menu;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Revolution\Ordering\Contracts\Menu\MenuDriver;

class MicroCmsDriver implements MenuDriver
{
    /**
     * @return mixed
     */
    public function get()
    {
        $endpoint = config('ordering.menu.micro-cms.endpoint');

        $query = [
            'limit'  => config('ordering.menu.micro-cms.limit'),
            'orders' => config('ordering.menu.micro-cms.orders'),
        ];

        $response = Http::withHeaders([
            'X-API-KEY' => config('ordering.menu.micro-cms.api_key'),
        ])->get($endpoint, $query);

        return collect($response->json('contents'))->map(function ($item) {
            $item['image'] = Arr::get($item, 'image.url').config('ordering.menu.micro-cms.image');

            return $item;
        });
    }
}
