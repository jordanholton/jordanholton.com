<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MomentController as AdminMomentController;
use App\Http\Controllers\MomentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::inertia('/', 'Welcome')->name('home');
Route::inertia('/about', 'About')->name('about');
Route::inertia('/skills', 'Skills')->name('skills');
Route::inertia('/work', 'Work')->name('work');
Route::get('/moments', [MomentController::class, 'index'])->name('moments');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (unauthenticated)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Authenticated
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminMomentController::class, 'index'])->name('dashboard');
        Route::get('/moments/create', [AdminMomentController::class, 'create'])->name('moments.create');
        Route::post('/moments', [AdminMomentController::class, 'store'])->name('moments.store');
        Route::get('/moments/{moment}/edit', [AdminMomentController::class, 'edit'])->name('moments.edit');
        Route::put('/moments/{moment}', [AdminMomentController::class, 'update'])->name('moments.update');
        Route::delete('/moments/{moment}', [AdminMomentController::class, 'destroy'])->name('moments.destroy');
    });
});
