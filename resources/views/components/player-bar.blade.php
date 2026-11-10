@props(['accent' => true])

{{--
    Barra del reproductor, siempre visible. Todo lo que cambia se marca con data-player-*
    y lo actualiza resources/js/player.js. Si la vista ya tiene su propio botón primario
    (accent = false), el botón de reproducir de la barra pasa a estilo contorno.
--}}
@php($first = \App\Support\Catalog::tracks()->first())

<section aria-label="Reproductor" {{ $attributes->merge(['class' => 'flex h-16 items-center justify-between gap-3 border-t border-line bg-surface-raised px-4 md:grid md:h-20 md:grid-cols-[1fr_2fr_1fr]']) }}>
    <div class="flex min-w-0 items-center gap-3">
        <a href="{{ route('player') }}" class="flex min-w-0 items-center gap-3 rounded-md">
            <span class="sr-only">Abrir reproductor.</span>
            <x-cover data-player-cover data-count="3" :bars="array_slice($first['bars'], 0, 3)" class="size-12 shrink-0 gap-0.5 rounded-sm p-2" />
            <span class="min-w-0">
                <span data-player-title class="block truncate text-body-sm font-bold text-ink">{{ $first['title'] }}</span>
                <span data-player-artist class="block truncate text-body-sm text-ink-muted">{{ $first['artist'] }}</span>
            </span>
        </a>
        <div class="hidden md:block">
            <x-icon-button label="Guardar en tu biblioteca" icon="heart" variant="toggle" :pressed="false" data-player-like />
        </div>
    </div>

    <div class="flex shrink-0 flex-col items-center gap-2 md:w-full">
        <div class="flex items-center gap-2 md:gap-6">
            <div class="hidden md:block">
                <x-icon-button label="Aleatorio" icon="shuffle" variant="toggle" :pressed="false" data-player-shuffle />
            </div>
            <x-icon-button label="Anterior" icon="prev" data-player-prev />
            <x-icon-button label="Reproducir" icon="play" :variant="$accent ? 'primary' : 'outline'" data-player-toggle>
                <x-icon name="play" data-icon="play" />
                <x-icon name="pause" data-icon="pause" class="hidden" />
            </x-icon-button>
            <x-icon-button label="Siguiente" icon="next" data-player-next />
        </div>
        <x-progress class="hidden w-full max-w-xl md:flex" />
    </div>

    <div class="hidden items-center justify-end gap-2 text-ink-muted md:flex">
        <x-icon name="volume" />
        <x-progress kind="volume" label="Volumen" :value="70" :with-times="false" class="w-24" />
    </div>
</section>
