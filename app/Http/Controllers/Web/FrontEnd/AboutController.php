<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $about = Section::where('name', 'about-page.about')->firstOrFail();

        return view('pages.frontend.about.index', [
            'title' => 'About',
            'about' => $about,
        ]);
    }
}
