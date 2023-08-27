<div class="m-6">
    <x-ordering::label for="table" :value="__('テーブル')"/>

    <x-ordering::input id="table"
                       class="block mt-1 mb-6"
                       type="text"
                       name="table"
                       wire:model.live="table"
                       required/>

    <h3 class="font-bold">{{ __('Table') }} {{ $table }}</h3>

    <x-ordering::qr :url="route('order', ['table' => $table])"></x-ordering::qr>
</div>
