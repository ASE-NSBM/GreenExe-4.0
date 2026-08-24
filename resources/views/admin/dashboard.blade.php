@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="font-display text-2xl font-bold text-white">Dashboard</h1>
    <p class="mt-1 text-sm text-light-gray/60">Registration summary for {{ config('greenexe.event.name') }}.</p>

    {{-- FR-58 --}}
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="gx-card">
            <p class="text-sm text-light-gray/60">Total registrations</p>
            <p class="mt-2 font-display text-3xl font-bold text-white">{{ $totalRegistrations }}</p>
        </div>
        <div class="gx-card">
            <p class="text-sm text-light-gray/60">Total participants</p>
            <p class="mt-2 font-display text-3xl font-bold text-white">{{ $totalMembers }}</p>
        </div>
        <div class="gx-card">
            <p class="text-sm text-light-gray/60">Pending review</p>
            <p class="mt-2 font-display text-3xl font-bold text-eco-lime">{{ $byStatus['pending'] ?? 0 }}</p>
        </div>
        <div class="gx-card">
            <p class="text-sm text-light-gray/60">Approved</p>
            <p class="mt-2 font-display text-3xl font-bold text-fresh-green">{{ $byStatus['approved'] ?? 0 }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="gx-card">
            <h2 class="font-display text-lg font-semibold text-white">By status</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @foreach (\App\Models\Registration::STATUSES as $status)
                    <li class="flex items-center justify-between">
                        <span class="text-light-gray/70">{{ Str::headline($status) }}</span>
                        <span class="font-semibold text-white">{{ $byStatus[$status] ?? 0 }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="gx-card">
            <h2 class="font-display text-lg font-semibold text-white">By category</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @foreach (config('greenexe.categories') as $key => $label)
                    <li class="flex items-center justify-between">
                        <span class="text-light-gray/70">{{ $label }}</span>
                        <span class="font-semibold text-white">{{ $byCategory[$key] ?? 0 }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-8 gx-card">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-lg font-semibold text-white">Latest registrations</h2>
            <a href="{{ route('admin.registrations.index') }}" class="text-sm text-cyan-tech hover:underline">View all →</a>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase tracking-wider text-light-gray/50">
                    <tr>
                        <th class="py-2 pr-4">Reference</th>
                        <th class="py-2 pr-4">Team</th>
                        <th class="py-2 pr-4">Project</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($latest as $registration)
                        <tr>
                            <td class="py-3 pr-4">
                                <a href="{{ route('admin.registrations.show', $registration) }}" class="text-cyan-tech hover:underline">
                                    {{ $registration->registration_code }}
                                </a>
                            </td>
                            <td class="py-3 pr-4 text-white">{{ $registration->team_name }}</td>
                            <td class="py-3 pr-4 text-light-gray/70">{{ Str::limit($registration->project_title, 40) }}</td>
                            <td class="py-3 pr-4">@include('admin.partials.status-badge', ['status' => $registration->status])</td>
                            <td class="py-3 text-light-gray/60">{{ $registration->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-6 text-center text-light-gray/50">No registrations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
