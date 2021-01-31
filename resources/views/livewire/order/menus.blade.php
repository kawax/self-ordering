<div class="mx-auto mb-40">
    @include('ordering::order.header')

    @include('ordering::order.category')

    <div class="px-3">
        @foreach($menus->groupBy('category') as $category => $items)
            @include('ordering::order.item')
        @endforeach
    </div>

    @include('ordering::order.footer')
</div>
