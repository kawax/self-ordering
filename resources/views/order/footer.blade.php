<footer class="flex justify-center">
    <div class="bg-white fixed w-full bottom-0 shadow-lg border-t border-primary-500 p-3 text-center">
        <span>{{ $this->items->count() }}個の商品</span>

        <span class="font-bold">合計{{ $this->items->sum('price') }}円
</span>

        <x-ordering::button wire:click="redirectTo" :disabled="empty(session('cart'))">注文に進む</x-ordering::button>

        <div class="mt-3">
            <x-ordering::secondary-button wire:click="resetCart">すべて削除</x-ordering::secondary-button>
        </div>
    </div>
</footer>
