<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Comment;
use Illuminate\Http\Request;

class BoardCommentsController extends Controller
{
    public function store(Request $request, $id)
    {
        $board = Board::find($id);
        $this->validate($request, [
            'body' => 'required'
        ]);

        $comment = $request->user()->comments()->create([
            'body' => $request->body,
            'board_id' => $board->id,
        ]);

        $html = view('boards.partials.comment', compact('comment'))->render();
        return $html;
    }

    public function destroy($board, $comment)
    {
        $comment = Comment::where('board_id', $board)->findOrFail($comment);
        $comment->delete();
    }
}