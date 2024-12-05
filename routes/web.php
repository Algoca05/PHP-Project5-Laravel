<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Auth; 
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\UserManagementComponent;

Route::get('/', [ViewController::class, 'index']);

Route::get('/register', [ViewController::class, 'register']);

Route::post('/register', [UsersController::class, 'register'])->name('users.register');

Route::get('/login', [ViewController::class, 'login']);

Route::post('/login', [UsersController::class, 'enterUsers'])->name('users.login');

Route::get('/home', HomeComponent::class)->name('home')->middleware('auth');

Route::get('/homeA', [HomeController::class, 'render']);

Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

Route::get('/music', [ViewController::class, 'music'])->name('music');

Route::get('/reloj', [ViewController::class, 'reloj'])->name('reloj');

Route::get('/tamagotchi', [ViewController::class, 'tamagotchi'])->name('tamagotchi');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user-management', UserManagementComponent::class)->name('user_management');
});
