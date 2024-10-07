<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardsController extends Controller
{
  public function index()
  {
    $boards = Board::with('user')->paginate(20);
    return view('admin.boards.index', [
      'boards' => $boards
    ]);
  }

  public function edit($id)
  {
    $board = Board::find($id);
    return view('admin.boards.edit', [
      'board' => $board
    ]);
  }

  public function update(Request $request, $board)
  {
    $board = Board::find($board);
    if (request()->hasFile('board_image')) {
      $filename = request()->file('board_image')->store('public/images');
      $board->image = basename($filename);
    }
    $board->title = request('board_title');
    $board->description = request('board_description');
    $board->update();
    return redirect()->route('admin.boards.index');
  }

  public function destroy($id)
  {
    $board = Board::find($id);
    $board->delete();
    return redirect()->route('admin.boards.index');
  }

  public function search(Request $request)
  {
    $q = request('q');
    $boards = Board::where('title', 'like', '%' . $q . '%')
      ->orWhere('description', 'like', '%' . $q . '%')
      ->paginate(20);

    return view('admin.boards.index', [
      'boards' => $boards,
      'q' => $q
    ]);
  }
}