<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Auth; // Add this line

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ViewController::class, 'index']);

Route::get('/register', [ViewController::class, 'register']);

Route::post('/register', [UsersController::class, 'postUsers'])->name('users.register');

Route::get('/login', [ViewController::class, 'login']);

Route::post('/login', [UsersController::class, 'enterUsers'])->name('users.login');

Route::get('/home', [ViewController::class, 'home'])->name('home')->middleware('auth');

Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

Route::get('/music', [ViewController::class, 'music'])->name('music');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user-management', [ViewController::class, 'userManagement'])->name('user_management');
    Route::post('/admin/user-management/{id}', [UsersController::class, 'updateUserRole'])->name('update_user_role');
    Route::delete('/admin/user-management/{id}', [UsersController::class, 'deleteUser'])->name('delete_user');
});
