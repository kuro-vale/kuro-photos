<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/photos', PhotoController::class);

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/settings', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/settings', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/settings', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');
