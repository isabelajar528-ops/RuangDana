<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/transactions', [DashboardController::class, 'storeTransaction'])->name('transactions.store');
Route::delete('/transactions/{transaction}', [DashboardController::class, 'destroyTransaction'])->name('transactions.destroy');
Route::post('/goals', [DashboardController::class, 'storeGoal'])->name('goals.store');
Route::delete('/goals/{goal}', [DashboardController::class, 'destroyGoal'])->name('goals.destroy');