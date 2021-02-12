<div class="mx-auto pb-40">
    @include('ordering::order.header')

    <div class="p-3 m-6 text-center">
        <h2 class="text-3xl">{{ __('PayPayの支払い完了を待っています') }}</h2>
        <div>{{ __('注文はまだ完了していません。いつまでもこの画面から進まない時は店員をお呼びください。') }}</div>

        <div wire:poll="check">
            {{ $status ?? '...' }}
        </div>
    </div>

    <x-ordering::fixed-footer>
        <div class="m-3">
            <x-ordering::button wire:click="back">
                {{ __('商品選択に戻る') }}
            </x-ordering::button>
        </div>
    </x-ordering::fixed-footer>
</div>
