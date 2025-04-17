<?php

use App\Http\Controllers\Web\Resume\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/resume', [ResumeController::class,'index'])->name('be.resume.index');
Route::put('/resume/update', [ResumeController::class,'update'])->name('be.resume.update');
