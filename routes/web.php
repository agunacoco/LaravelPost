<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
Route::get('/posts/index',[PostsController::class, 'index'])->name('posts.index');
Route::get('/posts/onlike',[PostsController::class, 'onlike'])->name('posts.onlike');
Route::get('/posts/myindex', [PostsController::class, 'myindex'])->name('posts.myindex');
Route::get('/posts/show/{id}', [PostsController::class, 'show'])->name('posts.show');
Route::get('posts/{post}', [PostsController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostsController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostsController::class, 'delete'])->name('posts.delete');
