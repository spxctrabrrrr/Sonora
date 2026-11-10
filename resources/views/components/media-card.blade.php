@props(['title', 'meta', 'time', 'bars' => [], 'href' => null])

{{-- Tarjeta de playlist o canción. Con href es un enlace; sin href, un botón (por ejemplo, para reproducir). --}}
@php
    $tag = $href ? 'a' : 'button';
    $extra = $href ? ['href' => $href] : ['type' => 'button'];
@endphp

<{{ $tag }} {{ $attributes->merge($extra + ['class' => 'group block w-full rounded-md bg-surface-raised p-4 text-left transition hover:bg-surface-high hover:shadow-raise']) }}>
    <x-cover :bars="$bars" class="mb-4 aspect-square gap-1 rounded-md p-4 group-hover:bg-surface-base" />
    <span class="block truncate text-heading text-ink">{{ $title }}</span>
    <span class="mt-1 block truncate text-body-sm text-ink-muted">{{ $meta }}</span>
    <span class="mt-2 block font-mono text-mono-sm text-ink-muted">{{ $time }}</span>
</{{ $tag }}>
