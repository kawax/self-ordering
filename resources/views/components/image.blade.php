@props(['src'])

<img src="{{ $src ?? config('ordering.menu.no_image') }}"
     {{ $attributes->merge(['class' => 'rounded-md h-24 object-contain object-right-top']) }}
     alt="">
