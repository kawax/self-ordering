<?php

declare(strict_types=1);

namespace Revolution\Ordering\Menu;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Menu\MenuDriver;

class ContentfulDriver implements MenuDriver
{
    use Macroable;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @inheritDoc
     */
    public function get(): mixed
    {
        $config = config('ordering.menu.contentful');

        $endpoint = Arr::get($config, 'endpoint');

        $query = [
            'content_type' => Arr::get($config, 'type'),
            'limit'        => Arr::get($config, 'limit'),
            'order'        => Arr::get($config, 'order'),
        ];

        $this->response = Http::withToken(Arr::get($config, 'api_key'))
                              ->get($endpoint, $query);

        return collect($this->response->json('items'))
            ->map([$this, 'transformItem']);
    }

    /**
     * @param  array  $item
     * @return array
     */
    public function transformItem(array $item): array
    {
        $collection = collect([
            'id'       => Arr::get($item, 'sys.id'),
            'name'     => Arr::get($item, 'fields.name'),
            'text'     => Arr::get($item, 'fields.text'),
            'category' => Arr::get($item, 'fields.category'),
            'price'    => Arr::get($item, 'fields.price'),
        ]);

        if (Arr::has($item, 'fields.image')) {
            $image_id = Arr::get($item, 'fields.image.sys.id');

            $image = collect($this->response->json('includes.Asset'))
                ->firstWhere('sys.id', $image_id);

            $collection->put('image', Arr::get($image, 'fields.file.url'));
        }

        return $collection->toArray();
    }
}
