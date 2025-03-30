<?php

use App\Http\Controllers\Web\BackEnd\SocialMediaController;
use Illuminate\Support\Facades\Route;

Route::get('/social-media', [SocialMediaController::class, 'index'])->name('be.social-media.index');
Route::get('/social-media/create', [SocialMediaController::class, 'create'])->name('be.social-media.create');
Route::post('/social-media/store', [SocialMediaController::class, 'store'])->name('be.social-media.store');
Route::get('/social-media/{socialMedia:slug}', [SocialMediaController::class, 'edit'])->name('be.social-media.edit');
Route::put('/social-media/{socialMedia:slug}', [SocialMediaController::class, 'update'])->name('be.social-media.update');
Route::delete('/social-media/{socialMedia:slug}', [SocialMediaController::class, 'destroy'])->name('be.social-media.destroy');
Route::get('/social-media/mass/destroy', [SocialMediaController::class, 'massDestroy'])->name('be.social-media.mass.destroy');

Route::post('/social-media/generate-slug', [SocialMediaController::class, 'generateSlug'])->name('be.social-media.generate.slug');