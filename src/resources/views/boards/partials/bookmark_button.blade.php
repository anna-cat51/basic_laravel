@if ($board->bookmarks->where('user_id', Auth::user()->id)->isEmpty())
    <form method="POST" action="{{ route('bookmarks.store', ['board' => $board->id]) }}">
        @csrf
        <button type="submit">
            <i class="ri-heart-3-line text-2xl"></i>
        </button>
    </form>
@else
    <form method="POST" action="{{ route('bookmarks.destroy', ['board' => $board->id]) }}">
        @method('DELETE')
        @csrf
        <button type="submit">
            <i class="ri-heart-3-fill text-2xl text-rose-500"></i>
        </button>
    </form>
@endif