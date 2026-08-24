<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminRegistrationController extends Controller
{
    /**
     * Registration list with search and filters (FR-59 to FR-61).
     */
    public function index(Request $request)
    {
        $registrations = Registration::query()
            ->with('members')
            ->search($request->string('q')->toString())
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('category'), fn ($q) => $q->where('project_category', $request->string('category')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'statuses' => Registration::STATUSES,
            'categories' => config('greenexe.categories'),
        ]);
    }

    /**
     * Full team and project details (FR-62, FR-63).
     */
    public function show(Registration $registration)
    {
        $registration->load('members');

        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update registration status (FR-64).
     */
    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', Registration::STATUSES)],
        ]);

        $registration->update($data);

        return back()->with('status', "Registration {$registration->registration_code} marked as {$data['status']}.");
    }

    /**
     * Delete or archive an invalid registration (FR-65).
     */
    public function destroy(Request $request, Registration $registration)
    {
        if ($request->input('mode') === 'archive') {
            $registration->update(['status' => 'archived']);

            return redirect()->route('admin.registrations.index')
                ->with('status', "Registration {$registration->registration_code} archived.");
        }

        $code = $registration->registration_code;
        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('status', "Registration {$code} deleted.");
    }

    /**
     * Export registration data as CSV (FR-66).
     */
    public function export(Request $request): StreamedResponse
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
