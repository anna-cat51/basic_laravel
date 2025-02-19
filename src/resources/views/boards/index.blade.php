<x-app-layout>
    @section('title', '掲示板一覧')
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="mx-32">
        <form action="{{ route('boards.search') }}" method="GET" class="mt-3 flex rounded-lg overflow-hidden w-1/2">
            <input type="text" class="appearance-none border border-slate-300 rounded py-2 px-3 text-gray-700 w-2/3"
                name="q" placeholder="Search..." dusk="search-input" />
            <button class="py-2 px-4 border rounded ml-1" dusk="search-button">
                <i class="ri-search-line"></i>
                <span>検索</span>
            </button>
        </form>
        <div class="my-3 grid grid-cols-3 gap-4">
            @foreach ($boards as $board)
                <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('boards.show', ['board' => $board->id]) }}">
                        <img class="rounded-t-lg" src={{ Storage::url('images/' . $board->image) }} alt="" />
                    </a>
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('boards.show', ['board' => $board->id]) }}">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $board->title }}</h5>
                            </a>
                            @if (Auth::id() === $board->user_id)
                                <div class="flex text-2xl">
                                    <a href="{{ route('boards.edit', $board->id) }}"><i
                                            class="ri-edit-box-line mr-4"></i></a>
                                    <form action="{{ route('boards.destroy', $board->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="if(!confirm('本当に削除しますか？')){return false};">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                @include('boards.partials.bookmark_button')
                            @endif
                        </div>
                        <p>by {{ $board->user->name }}</p>
                        <p class="my-3 font-normal text-gray-700 dark:text-gray-400 break-words">
                            {{ $board->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @if (request()->has('q'))
            {{ $boards->appends(['q' => request('q')])->links() }}
        @else
            {{ $boards->links() }}
        @endif
    </div>
</x-app-layout>