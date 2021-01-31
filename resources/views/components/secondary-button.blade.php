<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-white border-2 border-primary-300 rounded-md font-semibold text-xs text-primary-500 uppercase tracking-widest active:bg-primary-700 focus:outline-none focus:border-primary-500 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
