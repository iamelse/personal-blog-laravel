<?php

use App\Http\Controllers\Web\BackEnd\PostCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/post-category', [PostCategoryController::class,'index'])->name('be.post-category.index');
Route::get('/post-category/create', [PostCategoryController::class,'create'])->name('be.post-category.create');
Route::post('/post-category/store', [PostCategoryController::class,'store'])->name('be.post-category.store');
Route::get('/post-category/{post_category:slug}/edit', [PostCategoryController::class,'edit'])->name('be.post-category.edit');
Route::put('/post-category/{post_category:slug}/update', [PostCategoryController::class,'update'])->name('be.post-category.update');
Route::delete('/post-category/{post_category:slug}/destroy', [PostCategoryController::class,'destroy'])->name('be.post-category.destroy');
Route::get('/post-category/mass-destroy', [PostCategoryController::class,'massDestroy'])->name('be.post-category.mass.destroy');
