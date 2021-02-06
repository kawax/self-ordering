<div id="{{ $category }}">
    <h3 class="text-xl font-bold">{{ $category }}</h3>
    <div>
        @foreach($items as $item)
            <x-ordering::item-card :item="$item">
                <x-ordering::button
                    wire:click="addCart('{{ Arr::get($item, 'id')  }}')">
                    {{ __('追加') }}
                </x-ordering::button>
            </x-ordering::item-card>
        @endforeach
    </div>
</div>
