<x-app-layout>
    @section('title', '掲示板詳細')
    <section class="text-gray-600 body-font w-2/3 mx-auto p-2">
        <div class="container my-12 flex px-5 py-24 md:flex-row flex-col items-center bg-white">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded" alt="hero"
                    src={{ Storage::url('images/' . $board->image) }} width="400">
            </div>
            <div
                class="lg:flex-grow md:w-1/2 lg:pl-4 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                <div class="flex items-center justify-between w-full">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                        {{ $board->title }}
                    </h1>
                    <div class="flex text-2xl">
                        @if ($board->user == Auth::user())
                            <a href="{{ route('boards.edit', $board->id) }}"><i class="ri-edit-box-line mr-4"></i></a>
                            <form action="{{ route('boards.destroy', $board->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="if(!confirm('本当に削除しますか？')){return false};">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        @else
                            @include('boards.partials.bookmark_button')
                        @endif
                    </div>
                </div>
                <div class="flex">
                    <p class="mb-8 leading-relaxed">
                        by {{ $board->user->name }}
                    </p>
                    <p class="mb-8 ml-4 leading-relaxed">
                        {{ $board->created_at->format('d M Y') }}
                    </p>
                </div>
                <p class="mb-8 leading-relaxed">
                    {{ $board->description }}
                </p>
            </div>
        </div>
        <form method='POST' action="{{ route('boards.comments.store', ['board' => $board->id]) }}"
            id="js-comment_form">
            @csrf
            <div class="flex mb-4">
                <input id="js-comment_body" name="body" type="text" placeholder="コメントを入力してください"
                    class="w-full px-3 py-2 border border-inherit mr-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    dusk="comment-body-input">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    dusk="comment-submit-button">
                    送信
                </button>
            </div>
        </form>
        <div class="comment-area">
            @foreach ($board->comments as $comment)
                @include('boards.partials.comment', ['comment' => $comment])
            @endforeach
        </div>
    </section>
</x-app-layout>