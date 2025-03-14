<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $hero = Section::where('name', 'hero')->firstOrFail();
        $about = Section::where('name', 'about')->firstOrFail();
        $skills = Skill::limit(10)->get();
        $callToAction = Section::where('name','cta')->firstOrFail();

        return view('pages.frontend.home.index', [
            'title' => 'Home',
            'hero' => $hero,
            'about' => $about,
            'skills' => $skills,
            'callToAction' => $callToAction
        ]);
    }
}
