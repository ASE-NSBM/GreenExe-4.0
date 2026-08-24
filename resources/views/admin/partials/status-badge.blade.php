@php
    $styles = [
        'pending' => 'bg-eco-lime/15 text-eco-lime',
        'reviewed' => 'bg-cyan-tech/15 text-cyan-tech',
        'approved' => 'bg-fresh-green/20 text-fresh-green',
        'rejected' => 'bg-red-500/15 text-red-300',
        'archived' => 'bg-white/10 text-light-gray/60',
    ];
@endphp

<span class="gx-badge {{ $styles[$status] ?? 'bg-white/10 text-light-gray/70' }}">
    {{ Str::headline($status) }}
</span>
