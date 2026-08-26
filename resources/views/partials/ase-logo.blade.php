@php
    $class = $class ?? 'h-16 w-16';
    $label = $label ?? 'text-lg';
    $logoUrl = $logoUrl ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScQceU8Rwl_DkgV3m6kh-wsorPCbFrzUImaJaKzLYAkoIOTYiOZ8KMWGCk&s=10';
@endphp

<img src="{{ $logoUrl }}" alt="{{ config('greenexe.organizer.name') }} logo"
    class="{{ $class }} rounded-2xl object-cover bg-white/5 border border-cyan-tech/30 shadow-lg shadow-cyan-tech/15"
    loading="lazy">