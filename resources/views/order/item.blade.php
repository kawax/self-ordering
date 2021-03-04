<div id="{{ $category }}">
    <h3 class="text-xl font-bold">{{ $category }}</h3>
    <div>
        @foreach($items as $item)
            <x-ordering::item-card :item="$item">
                @if(\Illuminate\Support\Facades\Date::parse(Arr::get($item, 'sold_out_until'))->lessThanOrEqualTo(now()))
                    <x-ordering::button
                        wire:click="addCart('{{ Arr::get($item, 'id')  }}')">
                        {{ __('追加') }}
                    </x-ordering::button>
                @else
                    <x-ordering::button :disabled="true">
                        {{ __('売り切れ') }}
                    </x-ordering::button>
                @endif
            </x-ordering::item-card>
        @endforeach
    </div>
</div>
