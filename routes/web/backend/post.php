<?php

use App\Http\Controllers\Web\BackEnd\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/post', [PostController::class,'index'])->name('be.post.index');
Route::get('/post/create', [PostController::class,'index'])->name('be.post.create');
Route::get('/post/{post:slug}/edit', [PostController::class,'edit'])->name('be.post.edit');
Route::put('/post/{post:slug}/update', [PostController::class,'update'])->name('be.post.update');
Route::delete('/post/{post:slug}/destroy', [PostController::class,'destroy'])->name('be.post.destroy');
Route::get('/post/mass-destroy', [PostController::class,'massDestroy'])->name('be.post.mass.destroy');
Route::get('/post/generate-slug', [PostController::class,'generateSlug'])->name('be.post.generate.slug');
