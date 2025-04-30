<?php

use App\Http\Controllers\Web\BackEnd\About\AboutController;
use Illuminate\Support\Facades\Route;

Route::get('/post', [AboutController::class,'index'])->name('be.post.index');
Route::get('/post/create', [AboutController::class,'index'])->name('be.post.create');
Route::get('/post/edit', [AboutController::class,'index'])->name('be.post.edit');
