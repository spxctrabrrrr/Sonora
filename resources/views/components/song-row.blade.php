@props(['number', 'title', 'artist', 'duration', 'current' => false])

{{--
    Fila de canción: número, título con artista y duración en mono.
    La pista actual lleva aria-current="true", fondo surface-high y su número en accent.
    Los data-f los usa el JS del reproductor para rellenar la cola.
--}}
<button
    type="button"
    aria-current="{{ $current ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => 'group grid w-full grid-cols-[24px_1fr_auto] items-center gap-3 rounded-md px-2 py-3 text-left transition hover:bg-surface-high aria-[current=true]:bg-surface-high']) }}
>
    <span data-f="number" class="font-mono text-mono-sm text-ink-muted group-aria-[current=true]:text-accent">{{ $number }}</span>
    <span class="min-w-0">
        <span data-f="title" class="block truncate text-body-sm font-bold text-ink">{{ $title }}</span>
        <span data-f="artist" class="block truncate text-body-sm text-ink-muted">{{ $artist }}</span>
    </span>
    <span data-f="duration" class="font-mono text-mono-sm text-ink-muted">{{ $duration }}</span>
</button>
