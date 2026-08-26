<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationExportController extends Controller
{
    /**
     * Export registration data as CSV, one row per team member (FR-66).
     *
     * This stays a plain route rather than a Filament action because it streams
     * a file download; the panel links to it and passes its active filters
     * through as query parameters.
     */
    public function __invoke(Request $request): StreamedResponse
    {
        $filename = 'greenexe-registrations-'.now()->format('Y-m-d-His').'.csv';

        $columns = [
            'registration_code', 'team_name', 'member_count', 'project_title', 'project_category',
            'status', 'submitted_at', 'member_role', 'full_name', 'student_id', 'email',
            'contact_number', 'whatsapp_number', 'institution',
        ];

        return response()->streamDownload(function () use ($request, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            Registration::query()
                ->with('members')
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
                ->when($request->filled('category'), fn ($q) => $q->where('project_category', $request->string('category')))
                ->orderBy('id')
                ->chunk(200, function ($registrations) use ($handle) {
                    foreach ($registrations as $registration) {
                        foreach ($registration->members as $member) {
                            fputcsv($handle, [
                                $registration->registration_code,
                                $registration->team_name,
                                $registration->member_count,
                                $registration->project_title,
                                $registration->project_category,
                                $registration->status,
                                $registration->created_at?->toDateTimeString(),
                                $member->is_leader ? 'leader' : 'member',
                                $member->full_name,
                                $member->student_id,
                                $member->email,
                                $member->contact_number,
                                $member->whatsapp_number,
                                $member->institution,
                            ]);
                        }
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
