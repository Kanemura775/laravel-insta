<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;

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


/**
 * HTTP REQUEST METHOD
 * to display a view file - use get()
 * if the request is from a form - use post(),patch(), and delete
 *
 * post()
 * FORM structure
 * <form action="#" method="POST">
 *          @csrf
 *          <button type="submit" class="btn btn-sm shadow-none p-0">
 *              <i class="fa-regular fa-heart"></i>
 *          </button>
 * </form>
 *
 * patch()
 * FORM structure
 * <form action="#" method="POST">
 *          @csrf
 *          @method('PATCH')
 *          <button type="submit" class="btn btn-sm shadow-none p-0">
 *              <i class="fa-regular fa-heart"></i>
 *          </button>
 * </form>
 *
 * delete()
 * FORM structure
 * <form action="#" method="POST">
 *          @csrf
 *          @method('DELETE')
 *          <button type="submit" class="btn btn-sm shadow-none p-0">
 *              <i class="fa-regular fa-heart"></i>
 *          </button>
 * </form>
 */

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

    //this route will store a comment
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
    //this route will delete a comment
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    //this route will serve the views>users>profile>show.blade.php
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    //this route will serve the views>users>profile>edit.blade.php
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    //this route will update a user information
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    //this route will serve the views>user>profile>followers.blade.php
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    //this route will serve the views>profile>following.blade.php
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

    //this route will store a like
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    //this route will delete a like
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    //this route will store a follow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    //this route will delete follow
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        //Users
        //URI : '/admin/users , ROUTE name: admin.users
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        //Posts
        Route::get('/posts', [PostsController::class, 'index'])->name('posts');

    });
});
