<?php

use App\Http\Controllers\Web\BackEnd\QuickLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/quick-link', [QuickLinkController::class, 'index'])->name('be.quick-link.index');
Route::get('/quick-link/create', [QuickLinkController::class, 'create'])->name('be.quick-link.create');
Route::post('/quick-link/store', [QuickLinkController::class, 'store'])->name('be.quick-link.store');
Route::get('/quick-link/{quickLink:slug}', [QuickLinkController::class, 'edit'])->name('be.quick-link.edit');
Route::put('/quick-link/{quickLink:slug}', [QuickLinkController::class, 'update'])->name('be.quick-link.update');
Route::delete('/quick-link/{quickLink:slug}', [QuickLinkController::class, 'destroy'])->name('be.quick-link.destroy');
Route::get('/quick-link/mass/destroy', [QuickLinkController::class, 'massDestroy'])->name('be.quick-link.mass.destroy');

Route::post('/quick-link/generate-slug', [QuickLinkController::class, 'generateSlug'])->name('be.quick-link.generate.slug');