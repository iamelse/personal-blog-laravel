<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeController extends Controller
{
    public function index(): View
    {
        $resume = Section::where('name', 'resume-page.resume')->firstOrFail();

        return view('pages.frontend.resume.index', [
            'title' => 'Resume',
            'resume' => $resume,
        ]);
    }
}
