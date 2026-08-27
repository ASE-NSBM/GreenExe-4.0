<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SmartCityContent extends Model
{
    use HasFactory;

    protected $table = 'smart_city_content';

    /**
     * @var array<string, string>
     */
    public const SECTIONS = [
        'vision' => 'Vision (smart city)',
        'pillar' => 'Pillar (smart city)',
        'highlight' => 'Highlight (home carousel)',
    ];

    protected $fillable = [
        'section',
        'title',
        'description',
        'icon',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Artwork for this block, or null when none has been supplied.
     *
     * Files live in public/assets/img/highlights/ named after the slug of the
     * title, so adding a photograph needs no code change. Kept on the model
     * because the home page, the Smart Green City page and the about page all
     * render the same blocks.
     */
    public function artwork(): ?string
    {
        $slug = Str::slug($this->title);

        $legacy = [
            // Supplied before the naming convention existed.
            'Smart buildings and connected infrastructure' => 'assets/img/Smartbuildings.jpg',
        ];

        $paths = array_filter([
            $legacy[$this->title] ?? null,
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

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
