<div class="p-3 m-6 text-center rounded-md border-2 border-primary-500">
    <h3 class="text-2xl">{{ __('支払い方法') }}</h3>

    @if(session()->has('payment_redirect_error'))
        <div class="font-bold">
            {{ session('payment_redirect_error') }}
        </div>
    @endif

    <div class="flex flex-col items-start">
        @foreach($payments as $method => $name)
            <label class="inline-flex items-center p-3">
                <input type="radio"
                       name="payment"
                       class="h-5 w-5 text-primary-500 focus:ring focus:ring-primary-300"
                       value="{{ $method }}"
                       wire:model.live="payment_method"/>
                <span class="ml-2">{{ $name }}</span>
            </label>
        @endforeach

        @if($payment_method === 'paypay')
            <div>
                {{ config('ordering.payment.paypay.prepare_message') }}
            </div>
        @endif
    </div>
</div>
