<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Public, curated sitemap for search crawlers and answer engines.
     */
    public function __invoke(): Response
    {
        $pages = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('competition'), 'priority' => '0.9'],
            ['loc' => route('register'), 'priority' => '0.9'],
            ['loc' => route('smart-city'), 'priority' => '0.8'],
            ['loc' => route('about'), 'priority' => '0.7'],
            ['loc' => route('rules'), 'priority' => '0.7'],
            ['loc' => route('faq'), 'priority' => '0.7'],
            ['loc' => route('organizer'), 'priority' => '0.6'],
            ['loc' => route('contact'), 'priority' => '0.5'],
        ];

        return response()
            ->view('sitemap', compact('pages'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
