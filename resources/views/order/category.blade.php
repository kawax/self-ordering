<div class="sticky top-0">
    <nav class="bg-white dark:bg-gray-800 mb-3 p-3 shadow-lg">
        @foreach($menus->groupBy('category')->keys() as $category)
            <a href="#{{ $category }}" class="px-3 hover:text-primary-400 hover:underline">
                {{ $category }}
            </a>
        @endforeach
    </nav>
</div>
