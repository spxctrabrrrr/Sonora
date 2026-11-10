@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
    $base = 'inline-flex items-center justify-center gap-1 rounded-pill border-2 px-6 py-3 text-body-sm font-bold transition disabled:cursor-not-allowed disabled:opacity-50';

    $variants = [
        'primary' => 'border-transparent bg-accent text-on-accent hover:bg-accent-hover disabled:hover:bg-accent',
        'secondary' => 'border-line-strong text-ink hover:bg-surface-high disabled:hover:bg-transparent',
        'ghost' => 'border-transparent text-ink-muted hover:bg-surface-high hover:text-ink disabled:hover:bg-transparent',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
