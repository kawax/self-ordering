<x-ordering-guest-layout>
    <x-ordering::card>
        <x-slot name="logo">
            <h1 class="text-3xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Password -->
            <div class="mt-4">
                <x-ordering::label for="password" :value="__('パスワード')"/>

                <x-ordering::input id="password" class="block mt-1 w-full"
                                   type="password"
                                   name="password"
                                   required autocomplete="current-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-ordering::button class="ml-3">
                    {{ __('ログイン') }}
                </x-ordering::button>
            </div>
        </form>
    </x-ordering::card>
</x-ordering-guest-layout>
