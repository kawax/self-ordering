<x-ordering::fixed-footer>
    <div class="m-3">
        <x-ordering::button wire:click="back"
                            wire:loading.attr="disabled">
            {{ __('商品選択に戻る') }}
        </x-ordering::button>
    </div>
</x-ordering::fixed-footer>
