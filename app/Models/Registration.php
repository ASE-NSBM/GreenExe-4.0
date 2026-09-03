<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Registration extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'reviewed', 'approved', 'rejected', 'archived'];

    protected $fillable = [
        'registration_code',
        'team_name',
        'member_count',
        'project_title',
        'project_category',
        'project_description',
        'problem_statement',
        'proposed_solution',
        'technology_used',
        'innovation_description',
        'expected_impact',
        'has_previous_hackathon_experience',
        'previous_hackathon_details',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'member_count' => 'integer',
            'has_previous_hackathon_experience' => 'boolean',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function leader(): HasMany
    {
        return $this->members()->where('is_leader', true);
    }

    /**
     * Build a unique public registration reference (FR-37).
     */
    public static function generateCode(): string
    {
        do {
            $code = 'GX4-'.now()->format('y').'-'.Str::upper(Str::random(6));
        } while (static::where('registration_code', $code)->exists());

        return $code;
    }

    /**
     * Free-text search across the fields organisers look teams up by.
     *
     * `like` is case-sensitive on PostgreSQL but not on SQLite, so the operator
     * follows the driver — otherwise searching "solar" would miss "Solar Foxes"
     * on Supabase while passing locally.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (blank($term)) {
            return $query;
        }

        $like = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

        return $query->where(function ($q) use ($term, $like) {
            $q->where('registration_code', $like, "%{$term}%")
                ->orWhere('team_name', $like, "%{$term}%")
                ->orWhere('project_title', $like, "%{$term}%")
                ->orWhere('previous_hackathon_details', $like, "%{$term}%")
                ->orWhereHas('members', function ($m) use ($term, $like) {
                    $m->where('full_name', $like, "%{$term}%")
                        ->orWhere('email', $like, "%{$term}%")
                        ->orWhere('student_id', $like, "%{$term}%");
                });
        });
    }
}
