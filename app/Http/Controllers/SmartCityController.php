<?php

namespace App\Http\Controllers;

use App\Models\SmartCityContent;

class SmartCityController extends Controller
{
    /**
     * Smart Green City concept page (FR-15 to FR-22).
     */
    public function index()
    {
        return view('smart-city', [
            'vision' => SmartCityContent::published()->where('section', 'vision')->get(),
            'pillars' => SmartCityContent::published()->where('section', 'pillar')->get(),
        ]);
    }
}
