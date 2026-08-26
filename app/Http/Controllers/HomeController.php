<?php

namespace App\Http\Controllers;

use App\Models\CompetitionInformation;
use App\Models\Faq;
use App\Models\SmartCityContent;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Home page (FR-1 to FR-7).
     */
    public function index()
    {
        $highlights = SmartCityContent::published()->where('section', 'highlight')->get();
        $highlights->each(fn ($highlight) => $highlight->image = $this->highlightImage($highlight->title));

        return view('home', [
            'highlights' => $highlights,
            // Overview, purpose and benefits share the second panel and stay
            // editable from the dashboard (FR-68 to FR-70).
            'sections' => CompetitionInformation::published()
                ->whereIn('section', ['overview', 'purpose', 'benefits'])
                ->get()
                ->keyBy('section'),
        ]);
    }

    /**
     * Artwork for a Smart Green City highlight, or null so the slide falls back
     * to its gradient. Drop a file named after the slug of the title into
     * public/assets/img/highlights/ and it is picked up automatically.
     */
    private function highlightImage(string $title): ?string
    {
        $slug = Str::slug($title);

        $candidates = [
            // Supplied before the naming convention existed.
            'Smart buildings and connected infrastructure' => 'assets/img/Smartbuildings.jpg',
        ];

        $paths = array_filter([
            $candidates[$title] ?? null,
            "assets/img/highlights/{$slug}.jpg",
            "assets/img/highlights/{$slug}.jpeg",
            "assets/img/highlights/{$slug}.png",
            "assets/img/highlights/{$slug}.webp",
        ]);

        foreach ($paths as $path) {
            if (is_file(public_path($path))) {
                return asset($path);
            }
        }

        return null;
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
