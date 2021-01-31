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
        $url = 'https://'.config('ordering.menu.micro-cms.service').'.microcms.io/api/v1/'.config('ordering.menu.micro-cms.api_endpoint');

        $query = [
            'limit'  => config('ordering.menu.micro-cms.limit'),
            'orders' => config('ordering.menu.micro-cms.orders'),
        ];

        $response = Http::withHeaders([
            'X-API-KEY' => config('ordering.menu.micro-cms.api_key'),
        ])->get($url, $query);

        return collect($response->json('contents'))->map(function ($item) {
            $item['image'] = Arr::get($item, 'image.url');

            return $item;
        });
    }
}
