<?php

use App\Http\Controllers\Web\BackEnd\Home\HeroController;
use Illuminate\Support\Facades\Route;

Route::get('/home/hero', [HeroController::class,'index'])->name('be.home.hero.index');
Route::put('/home/hero/update', [HeroController::class,'update'])->name('be.home.hero.update');