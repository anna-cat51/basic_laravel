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
        ];
        $data = request()->all();
        $validator = Validator::make($data, $rule);

        if ($validator->fails()) {
            return redirect('/boards/create')
                ->withErrors($validator)
                ->withInput();
        }

        $board = new Board();
        $board->fill($data);
        $board->user_id = Auth::user()->id;
        $board->save();

        return redirect('/boards');
    }
}