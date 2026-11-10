{{-- Esta vista tiene su propio botón primario ("Reproducir"), así que el de la barra pasa a contorno. --}}
<x-layouts.app :title="$playlist['name']" :bar-accent="false">
    <div class="flex flex-col gap-6 md:flex-row md:items-end">
        <x-cover :bars="$playlist['bars']" class="aspect-square w-48 shrink-0 gap-2 rounded-lg p-6" />

        <div class="min-w-0">
            <p class="text-caption uppercase text-ink-muted">Playlist</p>
            <h1 class="mt-1 text-title">{{ $playlist['name'] }}</h1>
            <p class="mt-2 max-w-xl text-body text-ink-muted">{{ $playlist['description'] }}</p>
            <p class="mt-2 font-mono text-mono text-ink-muted">{{ $playlist['count'] }} canciones · {{ $playlist['time'] }}</p>

            <div class="mt-4 flex flex-wrap gap-2">
                <x-button data-player-start="{{ $playlist['slug'] }}">Reproducir</x-button>
                <x-button variant="secondary" :href="route('player')">Abrir reproductor</x-button>
            </div>
        </div>
    </div>

    <ul class="mt-8 rounded-md bg-surface-raised p-2" aria-label="Canciones de {{ $playlist['name'] }}">
        @foreach ($tracks as $track)
            <li>
                <x-song-row
                    :number="sprintf('%02d', $loop->iteration)"
                    :title="$track['title']"
                    :artist="$track['artist']"
                    :duration="$track['time']"
                    data-track-id="{{ $track['id'] }}"
                    data-player-play="{{ $track['id'] }}"
                    data-player-queue="{{ $playlist['slug'] }}"
                />
            </li>
        @endforeach
    </ul>
</x-layouts.app>
