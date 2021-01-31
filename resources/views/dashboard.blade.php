<x-ordering-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    管理画面ですがメニューデータも注文データも別で管理するのでここには何もありません。
                    <div class="m-6">
                        <div class="my-6">
                            簡易的な使い方：このQRコードを店頭に掲示してお客さんに読み込んでもらいます。
                        </div>
                        <x-ordering::qr :url="route('order')"></x-ordering::qr>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-ordering-app-layout>
