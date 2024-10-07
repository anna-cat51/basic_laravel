<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::with('bookmarks')->paginate(20);

        return view('boards.index', [
            'boards' => $boards
        ]);
    }

    public function create()
    {
        return view('boards.create');
    }

    public function store()
    {
        $rule = [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:65535'],
        ];
        $data = request()->all();
        $validator = Validator::make($data, $rule);

        if ($validator->fails()) {
            return redirect('/boards/create')
                ->withErrors($validator)
                ->withInput();
        }
        $board = new Board();
        if (request()->hasFile('board_image')) {
            $filename = request()->file('board_image')->store('public/images');
            $board->image = basename($filename);
        }
        $board->fill($data);
        $board->user_id = Auth::user()->id;
        if ($board->save()) {
            return redirect('/boards')->with('success', '掲示板を作成しました。');
        }
    }
    public function show($id)
    {
        $board = Board::find($id);

        return view('boards.show', compact('board'));
    }
}