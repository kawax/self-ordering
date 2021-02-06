<x-ordering-guest-layout>
    <x-ordering::auth-card>
        <x-slot name="logo">
            <h1 class="text-3xl">{{ config('app.name', 'Laravel') }}</h1>
        </x-slot>

        <form method="GET" action="{{ route('order') }}">

            <div class="mt-4">
                <div class="mb-3">{{ __('スマホで注文するセルフオーダー')  }}</div>

                <x-ordering::label for="table" :value="__('テーブル番号を入力してください')"/>

                <x-ordering::input id="table" class="block mt-1 w-full"
                                   type="text"
                                   name="table"
                                   required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if(config('ordering.takeout'))
                    <a href="{{ route('order',['table' => 'takeout']) }}" class="underline text-sm">
                        {{ __('テイクアウトはこちらから') }}
                    </a>
                @endif
                <x-ordering::button class="ml-3">
                    {{ __('テーブル選択') }}
                </x-ordering::button>
            </div>
        </form>
    </x-ordering::auth-card>
</x-ordering-guest-layout>
