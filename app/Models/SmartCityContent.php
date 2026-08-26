<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
