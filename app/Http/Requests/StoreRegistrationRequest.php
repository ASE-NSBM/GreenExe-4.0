<?php

namespace App\Http\Requests;

use App\Models\TeamMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Server-side validation of every required field (FR-32 to FR-34, section 12.1).
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $min = (int) config('greenexe.team.min_members');
        $max = (int) config('greenexe.team.max_members');
        $phone = ['required', 'string', 'regex:/^\+?[0-9][0-9\s\-]{6,19}$/'];

        return [
            'team_name' => ['required', 'string', 'min:3', 'max:120'],
            'member_count' => ['required', 'integer', "min:{$min}", "max:{$max}"],

            'project_title' => ['required', 'string', 'min:3', 'max:150'],
            'project_category' => ['nullable', 'string', 'in:'.implode(',', array_keys(config('greenexe.categories')))],
            'project_description' => ['required', 'string', 'min:50', 'max:2000'],
            'problem_statement' => ['required', 'string', 'min:30', 'max:2000'],
            'proposed_solution' => ['required', 'string', 'min:30', 'max:2000'],
            'technology_used' => ['required', 'string', 'min:3', 'max:1000'],
            'innovation_description' => ['required', 'string', 'min:30', 'max:2000'],
            'expected_impact' => ['required', 'string', 'min:30', 'max:2000'],

            'members' => ['required', 'array', "min:{$min}", "max:{$max}"],
            'members.*.full_name' => ['required', 'string', 'min:3', 'max:120'],
            'members.*.student_id' => ['required', 'string', 'max:40'],
            'members.*.email' => ['required', 'email:rfc', 'max:150'],
            'members.*.contact_number' => $phone,
            'members.*.whatsapp_number' => $phone,
            'members.*.institution' => ['required', 'string', 'max:150'],

            'declaration' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'members.*.contact_number.regex' => 'Enter a valid contact number, for example 0771234567 or +94771234567.',
            'members.*.whatsapp_number.regex' => 'Enter a valid WhatsApp number, for example 0771234567 or +94771234567.',
            'declaration.accepted' => 'You must accept the competition rules and declaration before submitting.',
        ];
    }

    /**
     * Duplicate-registration rules (FR-35): a student ID or email may only be
     * used once inside a team, and once across the whole competition.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $members = collect($this->input('members', []))
                    ->take((int) $this->input('member_count'));

                $this->flagDuplicatesWithinTeam($validator, $members, 'student_id', 'student ID');
                $this->flagDuplicatesWithinTeam($validator, $members, 'email', 'email address');

                foreach ($members as $index => $member) {
                    if (! empty($member['student_id']) && TeamMember::where('student_id', $member['student_id'])->exists()) {
                        $validator->errors()->add(
                            "members.{$index}.student_id",
                            'This student ID is already part of a registered team.'
                        );
                    }

                    if (! empty($member['email']) && TeamMember::where('email', $member['email'])->exists()) {
                        $validator->errors()->add(
                            "members.{$index}.email",
                            'This email address is already part of a registered team.'
                        );
                    }
                }
            },
        ];
    }

    private function flagDuplicatesWithinTeam(Validator $validator, $members, string $field, string $label): void
    {
        $seen = [];

        foreach ($members as $index => $member) {
            $value = strtolower(trim($member[$field] ?? ''));

            if ($value === '') {
                continue;
            }

            if (isset($seen[$value])) {
                $validator->errors()->add(
                    "members.{$index}.{$field}",
                    "This {$label} is already used by another member of this team."
                );
            }

            $seen[$value] = true;
        }
    }

    protected function prepareForValidation(): void
    {
        if (is_array($this->input('members'))) {
            $this->merge([
                'members' => array_values(array_slice(
                    $this->input('members'),
                    0,
                    (int) $this->input('member_count')
                )),
            ]);
        }
    }
}
