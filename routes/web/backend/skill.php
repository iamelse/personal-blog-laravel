<?php

use App\Http\Controllers\Web\BackEnd\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/skill', [SkillController::class, 'index'])->name('be.skill.index');
Route::get('/skill/create', [SkillController::class, 'create'])->name('be.skill.create');
Route::post('/skill/store', [SkillController::class, 'store'])->name('be.skill.store');
Route::get('/skill/{skill:name}', [SkillController::class, 'edit'])->name('be.skill.edit');
Route::put('/skill/{skill:name}', [SkillController::class, 'update'])->name('be.skill.update');
Route::delete('/skill/{skill:name}', [SkillController::class, 'destroy'])->name('be.skill.destroy');
Route::get('/skill/mass/destroy', [SkillController::class, 'massDestroy'])->name('be.skill.mass.destroy');