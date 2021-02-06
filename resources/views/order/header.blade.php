<header class="p-10 text-white text-center bg-black bg-gradient-to-r from-primary-200 to-primary-500">
    <h1 class="text-3xl">{{ config('app.name', 'Laravel') }}</h1>
    <div>
        {{ __('テーブル : ') }}{{ session('table') }}
    </div>
    @include('ordering::order.info')
    @include('ordering::order.history')
</header>
