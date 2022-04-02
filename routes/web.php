<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function ()
{
    return redirect()->route('home');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Auth
Auth::routes();

// Photos
Route::resource('/photos', PhotoController::class);

// Users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/user/settings', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/user/settings', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/user/settings', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');
// User photos
Route::get('/user/photos/{user:username}', [UserController::class, 'user_photos'])->name('users.photos');
// User Dashboard
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('users.dashboard');

// Comments
Route::post('/photos/{photo}/comments/', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::put('/photos/{photo}/comments/{comment}', [CommentController::class, 'update'])->middleware('auth')->name('comments.update');
Route::delete('/photos/{photo}/comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');
