<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionInformation extends Model
{
    use HasFactory;

    protected $table = 'competition_information';

    /**
     * Content sections and the public pages that read them. Organizer details
     * live here too, which is what FR-70 manages.
     *
     * @var array<string, string>
     */
    public const SECTIONS = [
        'overview' => 'Overview (home, about)',
        'purpose' => 'Purpose (home, about)',
        'benefits' => 'Benefits (home, about)',
        'eligibility' => 'Eligibility (rules)',
        'team_requirements' => 'Team requirements (rules)',
        'project_requirements' => 'Project requirements (rules)',
        'submission' => 'Submission (rules)',
        'rules' => 'Rules (rules)',
        'organizer' => 'Organizer (organizer)',
    ];

    protected $fillable = [
        'section',
        'title',
        'body',
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
