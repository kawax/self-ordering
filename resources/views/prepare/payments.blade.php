<div class="p-3 m-6 text-center rounded-md border-2 border-primary-500">
    <h3 class="text-2xl">{{ __('支払い方法') }}</h3>

    <div class="flex flex-col items-start">

        @foreach($payments as $name => $method)
            <label class="inline-flex items-center p-3">
                <input type="radio" name="payment" class="h-5 w-5 text-primary-500 focus:ring focus:ring-primary-300"
                       value="{{ $name }}" wire:model="payment_method"/>
                <span class="ml-2">
                {{ $method }}
            </span>
            </label>
        @endforeach
    </div>
</div>
