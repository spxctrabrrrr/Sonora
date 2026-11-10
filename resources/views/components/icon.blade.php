@props(['name'])

@php
    // Glifos de 24px del sistema (assets/Icons). Usan currentColor para heredar el color del token.
    $icons = [
        'play' => '<path fill="currentColor" d="M8 5v14l11-7z"/>',
        'pause' => '<rect fill="currentColor" x="6" y="5" width="4" height="14" rx="1"/><rect fill="currentColor" x="14" y="5" width="4" height="14" rx="1"/>',
        'next' => '<path fill="currentColor" d="M6 5l9 7-9 7z"/><rect fill="currentColor" x="17" y="5" width="2" height="14" rx="1"/>',
        'prev' => '<path fill="currentColor" d="M18 5l-9 7 9 7z"/><rect fill="currentColor" x="5" y="5" width="2" height="14" rx="1"/>',
        'heart' => '<path fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>',
        'search' => '<g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="6"/><path d="M16 16l4 4"/></g>',
        'home' => '<path fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" d="M4 11l8-7 8 7v9h-5v-6H9v6H4z"/>',
        'library' => '<path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M5 5v14M10 5v14M15 6l4 13"/>',
        'shuffle' => '<path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 7h4l8 10h4M4 17h4l3-4M13 11l3-4h4M18 5l2 2-2 2M18 15l2 2-2 2"/>',
        'volume' => '<g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10v4h4l5 4V6L8 10z"/><path d="M16 9a4 4 0 0 1 0 6M18.5 6.5a8 8 0 0 1 0 11"/></g>',
    ];
@endphp

<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" {{ $attributes->merge(['class' => 'size-6']) }}>{!! $icons[$name] ?? '' !!}</svg>
