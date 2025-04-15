<?php

use App\Http\Controllers\Web\BackEnd\About\AboutController;
use Illuminate\Support\Facades\Route;

Route::get('/about', [AboutController::class,'index'])->name('be.about.index');
Route::put('/about/update', [AboutController::class,'update'])->name('be.about.update');
