@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-600 active:bg-primary-700 focus:outline-none focus:border-primary-500 focus:ring ring-primary-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
