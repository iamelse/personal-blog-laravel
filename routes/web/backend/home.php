<?php

use App\Http\Controllers\Web\BackEnd\Home\AboutController;
use App\Http\Controllers\Web\BackEnd\Home\CallToActionController;
use App\Http\Controllers\Web\BackEnd\Home\FooterController;
use App\Http\Controllers\Web\BackEnd\Home\HeroController;
use Illuminate\Support\Facades\Route;

Route::get('/home/hero', [HeroController::class,'index'])->name('be.home.hero.index');
Route::put('/home/hero/update', [HeroController::class,'update'])->name('be.home.hero.update');

Route::get('/home/about', [AboutController::class,'index'])->name('be.home.about.index');
Route::put('/home/about/update', [AboutController::class,'update'])->name('be.home.about.update');

Route::get('/home/cta', [CallToActionController::class,'index'])->name('be.home.cta.index');
Route::put('/home/cta/update', [CallToActionController::class,'update'])->name('be.home.cta.update');

Route::get('/home/footer', [FooterController::class,'index'])->name('be.home.footer.index');
Route::put('/home/footer/update', [FooterController::class,'update'])->name('be.home.footer.update');