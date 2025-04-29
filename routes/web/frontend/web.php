<?php

use App\Http\Controllers\Web\FrontEnd\ResumeController;
use App\Http\Controllers\Web\FrontEnd\AboutController;
use App\Http\Controllers\Web\FrontEnd\HomeController;
use App\Http\Controllers\Web\FrontEnd\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('fe.home.index');
Route::get('/about', [AboutController::class, 'index'])->name('fe.about.index');
Route::get('/resume', [ResumeController::class, 'index'])->name('fe.resume.index');

Route::get('/post', [PostController::class, 'index'])->name('fe.post.index');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('fe.post.show');
