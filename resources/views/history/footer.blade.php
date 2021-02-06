<footer class="flex justify-center">
    <div class="bg-white dark:bg-gray-800 fixed w-full bottom-0 shadow-lg border-t border-primary-500 p-3 text-center">
        <div class="m-3">
            <x-ordering::button wire:click="back">
                {{ __('商品選択に戻る') }}
            </x-ordering::button>
        </div>
    </div>
</footer>
