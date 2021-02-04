<div class="mx-auto pb-40">
    @include('ordering::order.header')

    <div class="p-3 m-6 text-center">
        <h2 class="text-3xl">{{ __('PayPayの支払い完了を待っています') }}</h2>
        <div wire:poll="check">
            {{ $status ?? '...' }}
        </div>
    </div>

    <footer class="flex justify-center">
        <div
            class="bg-white dark:bg-gray-800 fixed w-full bottom-0 shadow-lg border-t border-primary-500 p-3 text-center">
            <div class="mt-3">
                <x-ordering::secondary-button wire:click="back">商品選択に戻る</x-ordering::secondary-button>
            </div>
        </div>
    </footer>
</div>
