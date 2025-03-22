<?php

use App\Http\Controllers\Web\BackEnd\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'index'])->name('be.user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('be.user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('be.user.store');
Route::get('/user/{user:username}', [UserController::class, 'edit'])->name('be.user.edit');
Route::put('/user/{user:username}', [UserController::class, 'update'])->name('be.user.update');
Route::delete('/user/{user:username}', [UserController::class, 'destroy'])->name('be.user.destroy');
Route::get('/user/mass/destroy', [UserController::class, 'massDestroy'])->name('be.user.mass.destroy');