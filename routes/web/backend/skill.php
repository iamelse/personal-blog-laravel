<?php

use App\Http\Controllers\Web\BackEnd\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/skill', [SkillController::class, 'index'])->name('be.skill.index');
Route::get('/skill/create', [SkillController::class, 'create'])->name('be.skill.create');
Route::post('/skill/store', [SkillController::class, 'store'])->name('be.skill.store');
Route::get('/skill/{skill:slug}', [SkillController::class, 'edit'])->name('be.skill.edit');
Route::put('/skill/{skill:slug}', [SkillController::class, 'update'])->name('be.skill.update');
Route::delete('/skill/{skill:slug}', [SkillController::class, 'destroy'])->name('be.skill.destroy');
Route::get('/skill/mass/destroy', [SkillController::class, 'massDestroy'])->name('be.skill.mass.destroy');

Route::post('/skill/generate-slug', [SkillController::class, 'generateSlug'])->name('be.skill.generate.slug');