<footer class="flex justify-center">
    <div class="bg-white dark:bg-gray-800 fixed w-full bottom-0 shadow-lg border-t border-primary-500 p-3 text-center">
        <span>{{ $this->items->count() }}{{ __('個の商品') }}</span>

        <span class="font-bold">{{ __('合計') }}{{ $this->items->sum('price') }}{{ __('円') }}
</span>

        <x-ordering::button wire:click="redirectTo"
                            :disabled="empty(session('cart'))">
            {{ __('注文確認に進む') }}
        </x-ordering::button>

        <div class="mt-3">
            <x-ordering::secondary-button wire:click="resetCart">
                {{ __('すべて削除') }}
            </x-ordering::secondary-button>
        </div>
    </div>
</footer>
