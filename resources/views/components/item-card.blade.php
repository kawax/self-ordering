@props(['item'])

<div {{ $attributes->merge(['class' => 'm-3 p-3 rounded shadow-lg flex justify-between dark:bg-gray-800']) }}>
    <div>
        <h4 class="font-bold">{{ Arr::get($item, 'name') }}</h4>
        <div>{{ Arr::get($item, 'text') }}</div>
        <span>{{ Arr::get($item, 'price', 0) }}{{ __('円') }}</span>
        <div>
            {{ $slot }}
        </div>
    </div>
    <div>
        <x-ordering::image :src="Arr::get($item, 'image')"></x-ordering::image>
    </div>
</div>
