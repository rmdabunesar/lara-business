<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class HomeController extends Controller
{
    /**
     * Display the public home page.
     */
    public function Index()
    {
        $sliders = Slider::latest()->get();

        return view('home.index', compact('sliders'));
    }
}
