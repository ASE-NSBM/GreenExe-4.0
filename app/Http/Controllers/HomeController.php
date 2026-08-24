<?php

namespace App\Http\Controllers;

use App\Models\CompetitionInformation;
use App\Models\Faq;
use App\Models\SmartCityContent;

class HomeController extends Controller
{
    /**
     * Home page (FR-1 to FR-7).
     */
    public function index()
    {
        return view('home', [
            'highlights' => SmartCityContent::published()->where('section', 'highlight')->get(),
            'overview' => CompetitionInformation::published()->where('section', 'overview')->first(),
        ]);
    }

    /**
     * About GreenExE 4.0 (FR-8 to FR-14).
     */
    public function about()
    {
        return view('about', [
            'sections' => CompetitionInformation::published()
                ->whereIn('section', ['overview', 'purpose', 'benefits'])
                ->get()
                ->groupBy('section'),
            'faqs' => Faq::published()->take(5)->get(),
        ]);
    }

    /**
     * Organizer information (FR-49 to FR-52).
     */
    public function organizer()
    {
        return view('organizer');
    }

    public function contact()
    {
        return view('contact');
    }
}
