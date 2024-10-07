<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Auth;

class BookmarksController extends Controller
{
    public function store(Request $request , $board)
    {
        $bookmark = new Bookmark;
        $bookmark->board_id = $board;
        $bookmark->user_id = Auth::user()->id;
        $bookmark->save();
        return redirect()->back();
    }

    public function destroy($board)
    {
        $bookmark = Bookmark::where('board_id', $board)->where('user_id', Auth::user()->id)->first();
        $bookmark->delete();
        return redirect()->back();
    }
}