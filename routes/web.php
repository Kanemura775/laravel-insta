<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//this is route group for all the route accessable only by login user/authenticated users
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    //this route will serve views>users>posts>create.blade.php
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    //this route will serve a post
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    //this route will serve views>users>post>show.blade.php
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
    //this route will serve views>users>posts>edit.blade.php
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    //this route will update a post
    Route::patch('/post/{id}/update', [postController::class, 'update'])->name('post.update');
    //this route will delete a post
    Route::delete('/post/{id}/destroy', [postController::class, 'destroy'])->name('post.destroy');
});
