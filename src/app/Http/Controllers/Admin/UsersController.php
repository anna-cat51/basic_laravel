<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
  public function index()
  {
    $users = User::paginate(20);
    return view('admin.users.index', [
      'users' => $users
    ]);
  }

  public function edit($id)
  {
    $user = User::find($id);
    return view('admin.users.edit', [
      'user' => $user
    ]);
  }

  public function update(Request $request, $user)
  {
    $user = User::find($user);
    $user->name = request('user_name');
    $user->email = request('user_email');
    $user->update();
    return redirect()->route('admin.users.index');
  }

  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();
    return redirect()->route('admin.users.index');
  }

  public function search(Request $request)
  {
    $q = request('q');
    $users = User::where('name', 'like', '%' . $q . '%')
      ->orWhere('email', 'like', '%' . $q . '%')
      ->paginate(20);

    return view('admin.users.index', [
      'users' => $users,
      'q' => $q
    ]);
  }
}
