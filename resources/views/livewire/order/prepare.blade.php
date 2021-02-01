<div class="mx-auto pb-40">
    @include('ordering::order.header')

    <div class="p-3 m-6 text-center rounded-md border-2 border-primary-500">
        <h2 class="text-3xl">{{ __('注文の確認') }}</h2>
        @unless(config('ordering.payment.enabled'))
            <div class="font-bold">{{ config('ordering.shop.disabled_pay_message') }}</div>
        @endunless
    </div>

    <div class="px-6">
        <div>{{ __('追加メモ') }}</div>
        <x-ordering::textarea class="w-full" wire:model="memo"></x-ordering::textarea>
    </div>
    <div class="px-3">
        @include('ordering::prepare.item')
    </div>

    @include('ordering::prepare.footer')
</div>
