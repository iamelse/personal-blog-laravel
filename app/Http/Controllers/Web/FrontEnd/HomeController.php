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
        $skills = Skill::limit(10)->get();

        return view('pages.frontend.home.index', [
            'title' => 'Home',
            'hero' => $hero,
            'skills' => $skills
        ]);
    }
}
