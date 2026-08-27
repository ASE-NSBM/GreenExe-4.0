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
            // Overview, purpose and benefits share the second panel and stay
            // editable from the dashboard (FR-68 to FR-70).
            'sections' => CompetitionInformation::published()
                ->whereIn('section', ['overview', 'purpose', 'benefits'])
                ->get()
                ->keyBy('section'),
        ]);
    }

    /**
     * About GreenExE 4.0 (FR-8 to FR-14).
     */
    public function about()
    {
        return view('about', [
            'sections' => CompetitionInformation::published()->get()->groupBy('section'),
            'smartCityVision' => SmartCityContent::published()->where('section', 'vision')->get(),
            'smartCityPillars' => SmartCityContent::published()->where('section', 'pillar')->get(),
            'faqs' => Faq::published()->get(),
        ]);
    }

    /**
     * Organizer information (FR-49 to FR-52).
     */
    public function organizer()
    {
        return view('organizer', [
            // Editable from the dashboard (FR-70).
            'blocks' => CompetitionInformation::published()->where('section', 'organizer')->get(),
        ]);
    }

    public function contact()
    {
        return view('contact');
    }
}
