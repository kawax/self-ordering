<x-ordering-app-layout>
    <x-ordering::auth-card>
        <x-slot name="logo">
            <h1 class="text-3xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <div class="flex flex-col items-center">
            <div class="mb-6">
                {{ __('スマホでQRコードを読み込んでください。') }}
            </div>

            <x-ordering::qr :url="route('order')"></x-ordering::qr>
        </div>
    </x-ordering::auth-card>
</x-ordering-app-layout>
