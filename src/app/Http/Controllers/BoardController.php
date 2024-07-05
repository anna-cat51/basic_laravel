<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    public function index()
    {
        $boards = Board::all();

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
            'image' => ['image', 'max:2048'] // 画像のバリデーションを追加、最大2MBの制限
        ];

        $data = request()->validate($rule); // バリデーションを行う

        $filename = null;
        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('photos', $filename, 'public');
        }

        $board = new Board();
        $board->fill($data);
        $board->user_id = Auth::id(); // Auth::user()->id から Auth::id() に変更
        $board->image = $filename;
        $board->save();

        return redirect('/boards')->with('success', '掲示板を作成しました。');
    }
}