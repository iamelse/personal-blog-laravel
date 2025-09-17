<?php

use App\Http\Controllers\Web\BackEnd\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/contact', [ContactController::class,'index'])->name('be.contact.index');
Route::get('/contact/mass-destroy', [ContactController::class,'massDestroy'])->name('be.contact.mass.destroy');
Route::get('/contact/{contact}', [ContactController::class,'show'])->name('be.contact.show');
Route::delete('/contact/{contact}', [ContactController::class,'destroy'])->name('be.contact.destroy');
