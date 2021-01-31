<x-ordering-guest-layout>
    <x-ordering::card>
        <x-slot name="logo">
            <h1 class="text-3xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <div class="my-6">
            スマホでQRコードを読み込んでください。
        </div>

        <x-ordering::qr :url="route('order')"></x-ordering::qr>

    </x-ordering::card>
</x-ordering-guest-layout>
