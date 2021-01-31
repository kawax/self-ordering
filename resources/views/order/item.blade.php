<div id="{{ $category }}">
    <h3 class="text-xl font-bold">{{ $category }}</h3>
    <div>
        @foreach($items as $item)
            <div class="m-3 p-3 rounded shadow-lg flex justify-between">
                <div>
                    <h4 class="font-bold">{{ Arr::get($item, 'name') }}</h4>
                    <div>{{ Arr::get($item, 'text') }}</div>
                    <span>{{ Arr::get($item, 'price', 0) }}円</span>
                    <div>
                        <x-ordering::button
                            wire:click="addCart('{{ Arr::get($item, 'id')  }}')">追加
                        </x-ordering::button>
                    </div>
                </div>
                <div>
                    <x-ordering::image :src="Arr::get($item, 'image')"></x-ordering::image>
                </div>
            </div>
        @endforeach
    </div>
</div>
