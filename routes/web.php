<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;

// Public routes
Route::get('/', [CardController::class, 'index'])->name('home');

// Test route to check users
Route::get('/test/users', function () {
    $users = \App\Models\User::all();
    return response()->json($users);
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::middleware('admin')->group(function () {
    Route::get('/admin/cards', [CardController::class, 'index'])->name('admin.cards');
    Route::get('/admin/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/admin/cards', [CardController::class, 'store'])->name('cards.store');
    Route::get('/admin/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::put('/admin/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/admin/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
});
