<?php

namespace Database\Seeders;

use App\Models\CompetitionInformation;
use Illuminate\Database\Seeder;

class CompetitionInformationSeeder extends Seeder
{
    /**
     * Placeholder copy for every content section. Organisers replace this text
     * from the admin dashboard once the official rules are approved (SRS 18).
     */
    public function run(): void
    {
        $sections = [
            ['overview', 'Competition overview', 'GreenExE 4.0 invites student teams to design technology solutions that turn a green environment into a connected, efficient, intelligent and sustainable city.'],
            ['purpose', 'Purpose and objectives', 'Encourage students to apply technology and innovation to real sustainability problems, and to present workable smart-city solutions to an industry audience.'],
            ['benefits', 'Participant benefits', "Industry exposure and mentorship\nRecognition for sustainable innovation\nHands-on experience building smart-city solutions\nNetworking with the ASE community and partners"],
            ['eligibility', 'Who can participate', 'Eligibility is confirmed by the organisers before registration opens. Update this section with the approved criteria.'],
            ['team_requirements', 'Team requirements', 'Teams must stay within the approved minimum and maximum member counts. Each member must supply full contact details at registration.'],
            ['project_requirements', 'Project requirements', 'Projects must address the Smart Green City concept and describe a problem, a proposed solution, the technology used, the innovation and the expected impact.'],
            ['submission', 'Submission and presentation', 'Submission and presentation requirements are confirmed by the organisers before the competition begins.'],
            ['rules', 'Rules and disqualification', 'Incomplete, duplicated or misrepresented registrations may be disqualified. Final rules are published by the organisers.'],
        ];

        foreach ($sections as $index => [$section, $title, $body]) {
            CompetitionInformation::updateOrCreate(
                ['section' => $section, 'title' => $title],
                [
                    'body' => $body,
                    'sort_order' => $index,
                    'is_published' => true,
                ]
            );
        }
    }
}
