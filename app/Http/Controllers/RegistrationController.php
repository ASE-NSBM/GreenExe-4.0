<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    /**
     * Registration form (FR-23 to FR-31).
     */
    public function create()
    {
        abort_unless(config('greenexe.registration.open'), 403, 'Registration is currently closed.');

        return view('registration', [
            'categories' => config('greenexe.categories'),
            'minMembers' => config('greenexe.team.min_members'),
            'maxMembers' => config('greenexe.team.max_members'),
        ]);
    }

    /**
     * Validate, store and confirm a registration (FR-32 to FR-38).
     */
    public function store(StoreRegistrationRequest $request)
    {
        abort_unless(config('greenexe.registration.open'), 403, 'Registration is currently closed.');

        $data = $request->validated();

        try {
            $registration = DB::transaction(function () use ($data) {
                $hasPreviousExperience = (bool) $data['has_previous_hackathon_experience'];

                $registration = Registration::create([
                    'registration_code' => Registration::generateCode(),
                    'team_name' => $data['team_name'],
                    'member_count' => $data['member_count'],
                    'project_title' => $data['project_title'],
                    'project_category' => $data['project_category'] ?? null,
                    'project_description' => $data['project_description'],
                    'problem_statement' => $data['problem_statement'],
                    'proposed_solution' => $data['proposed_solution'],
                    'technology_used' => $data['technology_used'],
                    'innovation_description' => $data['innovation_description'],
                    'expected_impact' => $data['expected_impact'],
                    'has_previous_hackathon_experience' => $hasPreviousExperience,
                    'previous_hackathon_details' => $hasPreviousExperience
                        ? $data['previous_hackathon_details']
                        : null,
                    'status' => 'pending',
                ]);

                foreach ($data['members'] as $index => $member) {
                    $registration->members()->create([
                        'is_leader' => $index === 0,
                        'full_name' => $member['full_name'],
                        'student_id' => $member['student_id'],
                        'email' => $member['email'],
                        'contact_number' => $member['contact_number'],
                        'whatsapp_number' => $member['whatsapp_number'],
                        'institution' => $member['institution'],
                    ]);
                }

                return $registration;
            });
        } catch (\Throwable $e) {
            Log::error('GreenExE registration failed', ['exception' => $e]);

            return back()
                ->withInput()
                ->with('error', 'We could not save your registration right now. Please try again in a moment.');
        }

        // The reference is kept in the session so the confirmation page cannot be
        // used to browse submissions belonging to other teams (SRS 12.2).
        $request->session()->put('registration_code', $registration->registration_code);

        return redirect()->route('registration.success');
    }

    /**
     * Registration confirmation (FR-39 to FR-42).
     */
    public function success(Request $request)
    {
        $code = $request->session()->get('registration_code');

        if (! $code) {
            return redirect()->route('register')
                ->with('error', 'No recent registration was found in this session.');
        }

        $registration = Registration::with('members')
            ->where('registration_code', $code)
            ->firstOrFail();

        return view('confirmation', compact('registration'));
    }
}
