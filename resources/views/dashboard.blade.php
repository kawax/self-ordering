<x-ordering-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-900">
                    管理画面ですがメニューデータも注文データも別で管理するのでここには何もありません。
                    <div class="m-6">
                        <div class="my-6">
                            簡易的な使い方：このQRコードを店頭に掲示してお客さんに読み込んでもらいます。こちらは自分でテーブル番号を入力する共通QRコード。
                        </div>
                        <x-ordering::qr :url="route('order')"></x-ordering::qr>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-900">
                    テーブル番号入力済みのQRコード生成。店内のすべてのテーブル用のQRコードを事前に印刷してテーブルに置く使い方もできます。

                    <livewire:ordering.qr-code-generator></livewire:ordering.qr-code-generator>
                </div>
            </div>
        </div>
    </div>
</x-ordering-dashboard-layout>
