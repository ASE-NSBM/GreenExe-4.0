<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use App\Models\TeamMember;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegistrationStatsWidget extends StatsOverviewWidget
{
    /** Dashboard summary information (FR-58). */
    protected ?string $heading = 'Registrations';

    protected function getStats(): array
    {
        $byStatus = Registration::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $total = (int) $byStatus->sum();
        $pending = (int) ($byStatus['pending'] ?? 0);
        $approved = (int) ($byStatus['approved'] ?? 0);

        return [
            Stat::make('Teams registered', $total)
                ->description($total === 0 ? 'No submissions yet' : 'Across every status')
                ->color('primary'),

            Stat::make('Participants', TeamMember::count())
                ->description('Individual team members')
                ->color('info'),

            Stat::make('Awaiting review', $pending)
                ->description($pending > 0 ? 'Needs an organiser decision' : 'Nothing waiting')
                ->color($pending > 0 ? 'warning' : 'success'),

            Stat::make('Approved', $approved)
                ->description($total > 0 ? round($approved / $total * 100).'% of submissions' : '—')
                ->color('success'),
        ];
    }
}
