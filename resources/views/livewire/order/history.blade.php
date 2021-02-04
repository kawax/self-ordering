<div class="mx-auto pb-40">
    @include('ordering::order.header')

    <div class="p-3 m-6 text-center">
        <h2 class="text-3xl">{{ __('注文履歴') }}</h2>
        <div>
            <x-ordering::secondary-button wire:click="deleteHistory">履歴を削除</x-ordering::secondary-button>
        </div>
    </div>

    @if (session()->has('order-message'))
        <div class="p-3 m-6 text-center text-white font-bold bg-primary-500 rounded-md">
            {{ session('order-message') }}
        </div>
    @endif

    <div class="px-3">
        @foreach($this->histories as $history)
            @unless(empty(Arr::get($history, 'date')))
                <div class="m-3 p-3 rounded-md border-2 border-primary-500">
                    <div class="text-center">
                        <h3 class="text-2xl">{{ Arr::get($history, 'date') }}</h3>
                        <div class="p-3 font-bold">合計{{ collect(Arr::get($history, 'items'))->sum('price') }}円</div>
                        <div>{{ Arr::get($history, 'memo') }}</div>
                    </div>

                    @foreach(Arr::get($history, 'items', []) as $item)
                        <div class="m-3 p-3 rounded shadow-lg flex justify-between dark:bg-gray-800">
                            <div>
                                <h4 class="font-bold">{{ Arr::get($item, 'name') }}</h4>
                                <div>{{ Arr::get($item, 'text') }}</div>
                                <span>{{ Arr::get($item, 'price', 0) }}円</span>
                            </div>
                            <div>
                                <x-ordering::image :src="Arr::get($item, 'image')"></x-ordering::image>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endunless
        @endforeach
    </div>

    @include('ordering::history.footer')
</div>
