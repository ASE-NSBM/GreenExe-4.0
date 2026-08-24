@extends('layouts.admin')

@section('title', $registration->registration_code)

@section('content')
    <a href="{{ route('admin.registrations.index') }}" class="text-sm text-cyan-tech hover:underline">← Back to registrations</a>

    <div class="mt-4 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-white">{{ $registration->team_name }}</h1>
            <p class="mt-1 font-mono text-sm text-cyan-tech">{{ $registration->registration_code }}</p>
            <p class="mt-1 text-sm text-light-gray/60">
                Submitted {{ $registration->created_at->format('d M Y, H:i') }}
            </p>
        </div>
        @include('admin.partials.status-badge', ['status' => $registration->status])
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        {{-- FR-63 --}}
        <div class="gx-card lg:col-span-2">
            <h2 class="font-display text-lg font-semibold text-white">Project</h2>

            @php
                $fields = [
                    'project_title' => 'Title',
                    'project_category' => 'Category',
                    'project_description' => 'Description',
                    'problem_statement' => 'Problem statement',
                    'proposed_solution' => 'Proposed solution',
                    'technology_used' => 'Technology used',
                    'innovation_description' => 'Innovation',
                    'expected_impact' => 'Expected impact',
                ];
            @endphp

            <dl class="mt-4 space-y-4 text-sm">
                @foreach ($fields as $field => $label)
                    <div>
                        <dt class="text-light-gray/50">{{ $label }}</dt>
                        <dd class="mt-1 whitespace-pre-line text-light-gray">
                            @if ($field === 'project_category')
                                {{ config('greenexe.categories')[$registration->project_category] ?? '—' }}
                            @else
                                {{ $registration->{$field} }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="space-y-6">
            {{-- FR-64 --}}
            <div class="gx-card">
                <h2 class="font-display text-lg font-semibold text-white">Update status</h2>
                <form method="POST" action="{{ route('admin.registrations.update', $registration) }}" class="mt-4 space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="gx-input">
                        @foreach (\App\Models\Registration::STATUSES as $status)
                            <option value="{{ $status }}" @selected($registration->status === $status)>{{ Str::headline($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="gx-btn-primary w-full">Save status</button>
                </form>
            </div>

            {{-- FR-65 --}}
            <div class="gx-card border-red-400/20">
                <h2 class="font-display text-lg font-semibold text-white">Archive or delete</h2>
                <p class="mt-2 text-xs text-light-gray/60">
                    Archiving keeps the record and hides it from active review. Deleting removes the team and its members permanently.
                </p>

                <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}" class="mt-4 space-y-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="mode" value="archive" class="gx-btn-ghost w-full">Archive</button>
                    <button type="submit" name="mode" value="delete" class="gx-btn w-full border border-red-400/40 text-red-300 hover:bg-red-500/10"
                            onclick="return confirm('Permanently delete {{ $registration->registration_code }}? This cannot be undone.')">
                        Delete permanently
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- FR-62 --}}
    <div class="mt-6 gx-card">
        <h2 class="font-display text-lg font-semibold text-white">
            Team members ({{ $registration->members->count() }} of {{ $registration->member_count }})
        </h2>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase tracking-wider text-light-gray/50">
                    <tr>
                        <th class="py-2 pr-4">Role</th>
                        <th class="py-2 pr-4">Name</th>
                        <th class="py-2 pr-4">Student ID</th>
                        <th class="py-2 pr-4">Email</th>
                        <th class="py-2 pr-4">Contact</th>
                        <th class="py-2 pr-4">WhatsApp</th>
                        <th class="py-2">Institution</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($registration->members as $member)
                        <tr>
                            <td class="py-3 pr-4">{{ $member->is_leader ? 'Leader' : 'Member' }}</td>
                            <td class="py-3 pr-4 text-white">{{ $member->full_name }}</td>
                            <td class="py-3 pr-4 text-light-gray/70">{{ $member->student_id }}</td>
                            <td class="py-3 pr-4 text-light-gray/70">{{ $member->email }}</td>
                            <td class="py-3 pr-4 text-light-gray/70">{{ $member->contact_number }}</td>
                            <td class="py-3 pr-4 text-light-gray/70">{{ $member->whatsapp_number }}</td>
                            <td class="py-3 text-light-gray/70">{{ $member->institution }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
