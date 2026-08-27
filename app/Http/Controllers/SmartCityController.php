<?php

namespace App\Http\Controllers;

use App\Models\SmartCityContent;
use Illuminate\Support\Str;

class SmartCityController extends Controller
{
    /**
     * Smart Green City concept page (FR-15 to FR-22).
     */
    public function index()
    {
        $pillars = SmartCityContent::published()->where('section', 'pillar')->get();
        $pillars->each(fn ($pillar) => $pillar->image = $this->pillarImage($pillar->title));

        return view('smart-city', [
            'vision' => SmartCityContent::published()->where('section', 'vision')->get(),
            'pillars' => $pillars,
        ]);
    }

    /**
     * Artwork for a Smart Green City pillar.
     */
    private function pillarImage(string $title): ?string
    {
        $slug = Str::slug($title);

        $candidates = [
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
}
