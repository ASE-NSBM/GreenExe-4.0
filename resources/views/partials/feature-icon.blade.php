@php
    $index = (int) ($index ?? 0);
    $class = $class ?? 'h-5 w-5';
    $paths = [
        '<path d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6M12 4v3"/>',
        '<path d="M12 3v18M4 7h16M6 7l-2 5h4L6 7Zm12 0-2 5h4l-2-5ZM8 17h8"/>',
        '<path d="M4 19V5M4 5c4-3 8 3 16 0v14c-8 3-12-3-16 0ZM8 9h8M8 13h5"/>',
        '<path d="M3 18h18M5 18V9h14v9M4 9h16l-8-5-8 5ZM9 13h6"/>',
        '<path d="M4 20h16M6 20V8h12v12M4 8h16M8 4h8M12 4v4M9 12h6M9 16h6"/>',
        '<path d="M12 3a7 7 0 0 1 7 7c0 5-7 11-7 11S5 15 5 10a7 7 0 0 1 7-7Zm0 4v6m-3-3h6"/>',
        '<path d="M4 18h16M6 18V7h12v11M4 7h16l-8-4-8 4ZM9 11h6"/>',
        '<path d="M5 19h14M7 19V8h10v11M4 8h16M9 4h6M12 4v4M9 12h6"/>',
    ];
@endphp

<svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $paths[$index % count($paths)] !!}
</svg>
