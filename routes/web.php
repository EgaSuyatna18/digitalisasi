<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Middleware\IsSuperAdmin;

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(IsSuperAdmin::class)->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user_index');
        Route::post('/user', [UserController::class, 'store'])->name('user_store');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user_destroy');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user_update');
    });

    Route::get('/item', [ItemController::class, 'index'])->name('item_index');
    Route::post('/get_qr/{id}', [ItemController::class, 'getQr'])->name('get_qr');
    Route::post('/item', [ItemController::class, 'store'])->name('item_store');
    Route::delete('/item/{item}', [ItemController::class, 'destroy'])->name('item_destroy');
    Route::put('/item/{item}', [ItemController::class, 'update'])->name('item_update');

    Route::get('/get_item/{item}', [ItemController::class, 'getItem'])->name('get_item');

    Route::get('/item/{key}/search', [ItemController::class, 'search'])->name('search_item');

    Route::post('/logout', function(Request $request): RedirectResponse {
        Log::info('Melakukan logout. waktu: {waktu} username: {username}', ['waktu' => Date('d-m-Y h:i:s a'), 'username' => Auth::user()->username]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});


