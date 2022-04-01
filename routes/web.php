<?php

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
Route::get('/users/settings', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/settings', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/settings', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');
// User photos
Route::get('/users/photos/{user:username}', [UserController::class, 'user_photos'])->name('users.photos');
