<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Usability;

class HomeController extends Controller
{
    /**
     * Display the public home page.
     */
    public function Index()
    {
        $sliders = Slider::latest()->get();
        $usabilities = Usability::first();

        return view('home.index', compact('sliders', 'usabilities'));
    }
}
