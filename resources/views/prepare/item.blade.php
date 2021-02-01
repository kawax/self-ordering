@foreach($this->items as $index => $item)
    <div class="m-3 p-3 dark:bg-gray-800 rounded shadow-lg flex justify-between">
        <div>
            <h4 class="font-bold">{{ Arr::get($item, 'name') }}</h4>
            <div>{{ Arr::get($item, 'text') }}</div>
            <span>{{ Arr::get($item, 'price', 0) }}円</span>
            <div>
                <x-ordering::button
                    wire:click="deleteCart({{ $index }})">削除
                </x-ordering::button>
            </div>
        </div>
        <div>
            <x-ordering::image :src="Arr::get($item, 'image')"></x-ordering::image>
        </div>
    </div>
@endforeach
