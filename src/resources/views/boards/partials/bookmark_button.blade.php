@if ($board->bookmarks->where('user_id', Auth::user()->id)->isEmpty())
    <form method="POST" action="{{ route('bookmarks.store', ['board' => $board->id]) }}" class="bookmark-form">
        @csrf
        <button type="submit" dusk="bookmark-button">
            <i class="ri-heart-3-line text-2xl"></i>
        </button>
    </form>
@else
    <form method="POST" action="{{ route('bookmarks.destroy', ['board' => $board->id]) }}" class="bookmark-form">
        @method('DELETE')
        @csrf
        <button type="submit" id="js-unbookmark-{{ $board->id }}" dusk="unbookmark-button">
            <i class="ri-heart-3-fill text-2xl text-rose-500"></i>
        </button>
    </form>
@endif