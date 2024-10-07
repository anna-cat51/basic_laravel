<div class="bg-white rounded-lg p-4 mb-4" id=comment-id-{{ $comment->id }}>
    <div class="flex items-center">
        <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center mr-2">
            <span class="text-white text-lg font-medium">A</span>
        </div>
        <div class="w-full px-6">
            <div class="flex justify-between">
                <p class="text-gray-800 font-medium">{{ $comment->user->name }}</p>
                <p class="text-sm text-gray-600">Posted on {{ $comment->created_at->format('M d, h:i') }}</p>
            </div>
            <div class="text-gray-800">
                <p class="break-all">{{ $comment->body }}</p>
            </div>
            @if ($comment->user == Auth::user())
                <div class="flex flex-row-reverse">
                    <form
                        action="{{ route('boards.comments.destroy', ['board' => $comment->board, 'comment' => $comment]) }}"
                        method="POST" class="js-comment_delete_button" data-comment-id={{ $comment->id }}>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="if(!confirm('本当に削除しますか？')){return false};">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </div>
            @else
                <div class="flex flex-row-reverse"></div>
            @endif
        </div>
    </div>
</div>
