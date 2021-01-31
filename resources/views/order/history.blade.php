<div class="mt-3 text-center">
    @if(session()->has('history'))
        <a href="{{ route('history') }}">注文履歴</a>
    @endif
</div>
