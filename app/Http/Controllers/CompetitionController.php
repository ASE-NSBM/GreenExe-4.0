<?php

namespace App\Http\Controllers;

use App\Models\CompetitionInformation;

class CompetitionController extends Controller
{
    /**
     * Competition information (FR-4, FR-12).
     */
    public function index()
    {
        return view('competition', [
            'sections' => CompetitionInformation::published()->get()->groupBy('section'),
        ]);
    }

    /**
     * Rules & eligibility (FR-44 to FR-48).
     */
    public function rules()
    {
        return view('rules', [
            'sections' => CompetitionInformation::published()
                ->whereIn('section', ['eligibility', 'team_requirements', 'project_requirements', 'submission', 'rules'])
                ->get()
                ->groupBy('section'),
        ]);
    }
}
