@extends('layouts.admin')

@section('title', 'Registrations')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-white">Registrations</h1>
            <p class="mt-1 text-sm text-light-gray/60">{{ $registrations->total() }} record(s) found.</p>
        </div>

        {{-- FR-66 --}}
        <a href="{{ route('admin.registrations.export', request()->only('status', 'category')) }}" class="gx-btn-ghost">
            Export CSV
        </a>
    </div>

    {{-- FR-60, FR-61 --}}
    <form method="GET" action="{{ route('admin.registrations.index') }}" class="mt-6 gx-card grid gap-4 sm:grid-cols-4">
        <div class="sm:col-span-2">
            <label class="gx-label" for="q">Search</label>
            <input id="q" name="q" type="search" class="gx-input" value="{{ request('q') }}"
                   placeholder="Reference, team, project, member name, email or student ID">
        </div>

        <div>
            <label class="gx-label" for="status">Status</label>
            <select id="status" name="status" class="gx-input">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ Str::headline($status) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="gx-label" for="category">Category</label>
            <select id="category" name="category" class="gx-input">
                <option value="">All categories</option>
                @foreach ($categories as $key => $label)
                    <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="sm:col-span-4 flex gap-3">
            <button type="submit" class="gx-btn-primary">Apply filters</button>
            <a href="{{ route('admin.registrations.index') }}" class="gx-btn-ghost">Reset</a>
        </div>
    </form>

    {{-- FR-59 --}}
    <div class="mt-6 gx-card overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase tracking-wider text-light-gray/50">
                <tr>
                    <th class="py-2 pr-4">Reference</th>
                    <th class="py-2 pr-4">Team</th>
                    <th class="py-2 pr-4">Members</th>
                    <th class="py-2 pr-4">Project</th>
                    <th class="py-2 pr-4">Category</th>
                    <th class="py-2 pr-4">Status</th>
                    <th class="py-2 pr-4">Submitted</th>
                    <th class="py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($registrations as $registration)
                    <tr>
                        <td class="py-3 pr-4 font-mono text-xs text-cyan-tech">{{ $registration->registration_code }}</td>
                        <td class="py-3 pr-4 text-white">{{ $registration->team_name }}</td>
                        <td class="py-3 pr-4 text-light-gray/70">{{ $registration->members->count() }}</td>
                        <td class="py-3 pr-4 text-light-gray/70">{{ Str::limit($registration->project_title, 35) }}</td>
                        <td class="py-3 pr-4 text-light-gray/70">
                            {{ $categories[$registration->project_category] ?? '—' }}
                        </td>
                        <td class="py-3 pr-4">@include('admin.partials.status-badge', ['status' => $registration->status])</td>
                        <td class="py-3 pr-4 text-light-gray/60">{{ $registration->created_at->format('d M Y') }}</td>
                        <td class="py-3">
                            <a href="{{ route('admin.registrations.show', $registration) }}" class="text-cyan-tech hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-8 text-center text-light-gray/50">No registrations match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
@endsection
