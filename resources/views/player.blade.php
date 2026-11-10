{{-- Pantalla completa: sin barra lateral ni barra inferior. Su único botón primario es el de reproducir. --}}
<x-layouts.app title="Reproductor" :shell="false">
    <div class="grid lg:h-dvh lg:grid-cols-[1fr_320px]">
        <section aria-label="Reproduciendo" class="flex flex-col p-4 md:p-8">
            <div>
                <x-button variant="ghost" :href="route('home')">Volver al inicio</x-button>
            </div>

            <div class="flex flex-1 flex-col items-center justify-center gap-4 py-8">
                <x-cover data-player-cover :bars="$track['bars']" class="aspect-square w-full max-w-80 gap-2 rounded-lg p-8 shadow-raise" />

                <div class="text-center">
                    <h1 data-player-title class="text-title">{{ $track['title'] }}</h1>
                    <p class="mt-1 text-body-sm text-ink-muted">
                        <span data-player-artist>{{ $track['artist'] }}</span> · <span data-player-album>{{ $track['album'] }}</span>
                    </p>
                </div>

                <x-progress class="w-full max-w-md" />

                <div class="flex items-center gap-4 md:gap-8">
                    <x-icon-button label="Aleatorio" icon="shuffle" variant="toggle" :pressed="false" data-player-shuffle />
                    <x-icon-button label="Anterior" icon="prev" data-player-prev />
                    <x-icon-button label="Reproducir" icon="play" variant="primary" size="lg" data-player-toggle>
                        <x-icon name="play" data-icon="play" />
                        <x-icon name="pause" data-icon="pause" class="hidden" />
                    </x-icon-button>
                    <x-icon-button label="Siguiente" icon="next" data-player-next />
                    <x-icon-button label="Guardar en tu biblioteca" icon="heart" variant="toggle" :pressed="false" data-player-like />
                </div>
            </div>
        </section>

        <aside aria-labelledby="titulo-cola" class="bg-surface-raised p-4 md:p-6 lg:overflow-y-auto">
            <h2 id="titulo-cola" class="mb-4 text-heading">En cola</h2>
            <ul data-queue-list></ul>

            {{-- Plantilla que el JS clona por cada canción de la cola --}}
            <template data-queue-template>
                <li>
                    <x-song-row number="00" title="" artist="" duration="00:00" data-player-play="" data-player-queue="" data-track-id="" />
                </li>
            </template>
        </aside>
    </div>
</x-layouts.app>
