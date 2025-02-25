@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-xs border-gray-300 focus:border-primary-300 focus:ring-3 focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-800']) !!}>
