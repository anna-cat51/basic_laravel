<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardCommentsController extends Controller
{
  public function store(Request $request, $id)
  {
    $board = Board::find($id);
    $this->validate($request, [
      'body' => 'required'
    ]);

    $request->user()->comments()->create([
      'body' => $request->body,
      'board_id' => $board->id,
    ]);

    return redirect()->route('boards.show', $board);
  }
}