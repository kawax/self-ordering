<?php

declare(strict_types=1);

namespace Revolution\Ordering\Menu;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Menu\MenuDriver;

class MicroCmsDriver implements MenuDriver
{
    use Macroable;

    /**
     * @inheritDoc
     */
    public function get(): mixed
    {
        $config = config('ordering.menu.micro-cms');

        $endpoint = Arr::get($config, 'endpoint');

        $query = [
            'limit'  => Arr::get($config, 'limit'),
            'orders' => Arr::get($config, 'orders'),
        ];

        $response = Http::withHeaders([
            'X-API-KEY' => Arr::get($config, 'api_key'),
        ])->get($endpoint, $query);

        return collect($response->json('contents'))->map(function ($item) use ($config) {
            if (Arr::has($item, 'image.url')) {
                $item['image'] = Arr::get($item, 'image.url').Arr::get($config, 'image');
            }

            return $item;
        });
    }
}
