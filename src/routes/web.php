<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BoardCommentsController;
use App\Http\Controllers\BookmarksController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/boards/search', [BoardController::class, 'search'])->name('boards.search');
    Route::resource('boards', BoardController::class);
    Route::resource('boards.comments', BoardCommentsController::class)->only(['store', 'destroy']);
    Route::post('/boards/{board}/bookmark', [BookmarksController::class, 'store'])->name('bookmarks.store');
    Route::delete('/boards/{board}/bookmark', [BookmarksController::class, 'destroy'])->name('bookmarks.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});
