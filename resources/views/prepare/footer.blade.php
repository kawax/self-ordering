<x-ordering::fixed-footer>
    <span>{{ $this->items->count() }}{{ __('個の商品') }}</span>

    <span class="font-bold">{{ __('合計') }}{{ $this->items->sum('price') }}{{ __('円') }}
</span>

    <x-ordering::button wire:click="redirectTo" :disabled="empty(session('cart'))">
        {{ __('注文を確定して支払いに進む') }}
    </x-ordering::button>

    <div class="mt-3">
        <x-ordering::secondary-button wire:click="back">
            {{ __('商品選択に戻る') }}
        </x-ordering::secondary-button>
    </div>
</x-ordering::fixed-footer>>
