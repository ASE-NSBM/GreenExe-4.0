<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['Who can take part in GreenExE 4.0?', 'Eligibility is confirmed by the organisers. Check the Rules & Eligibility page for the approved criteria.'],
            ['How many members can a team have?', 'Teams must have between '.config('greenexe.team.min_members').' and '.config('greenexe.team.max_members').' members. The first member entered is the team leader.'],
            ['Does the project need to be finished before registering?', 'No. Registration collects your concept: the problem, your proposed solution, the technology you plan to use and the impact you expect.'],
            ['What happens after I register?', 'You receive a unique registration reference on screen. Keep it — organisers use it in all follow-up communication.'],
            ['Can I change my submission later?', 'Contact the organisers with your registration reference. Changes are handled by the ASE committee.'],
            ['Is my personal information public?', 'No. Participant details are only visible to authorised administrators.'],
        ];

        foreach ($faqs as $index => [$question, $answer]) {
            Faq::updateOrCreate(
                ['question' => $question],
                [
                    'answer' => $answer,
                    'sort_order' => $index,
                    'is_published' => true,
                ]
            );
        }
    }
}
