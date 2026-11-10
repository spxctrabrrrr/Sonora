@php
    $normalize = fn (string $text): string => mb_strtolower(\Illuminate\Support\Str::ascii($text));
@endphp

<x-layouts.app title="Buscar">
    <h1 class="mb-4 text-title">Buscar</h1>

    <form role="search" data-search-form class="max-w-xl">
        <x-search-field data-search-input />
    </form>

    <p data-search-count aria-live="polite" class="mt-4 font-mono text-mono-sm text-ink-muted"></p>

    <section data-search-section aria-labelledby="buscar-playlists" class="mt-6">
        <h2 id="buscar-playlists" class="mb-4 text-heading">Playlists</h2>
        <ul class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($playlists as $playlist)
                <li data-search-item data-search-text="{{ $normalize($playlist['name'].' '.$playlist['description']) }}">
                    <x-media-card
                        :href="route('playlists.show', $playlist['slug'])"
                        :title="$playlist['name']"
                        :meta="$playlist['count'].' canciones'"
                        :time="$playlist['time']"
                        :bars="$playlist['bars']"
                    />
                </li>
            @endforeach
        </ul>
    </section>

    <section data-search-section aria-labelledby="buscar-canciones" class="mt-8">
        <h2 id="buscar-canciones" class="mb-4 text-heading">Canciones</h2>
        <ul class="rounded-md bg-surface-raised p-2">
            @foreach ($tracks as $track)
                <li data-search-item data-search-text="{{ $normalize($track['title'].' '.$track['artist'].' '.$track['album']) }}">
                    <x-song-row
                        :number="sprintf('%02d', $loop->iteration)"
                        :title="$track['title']"
                        :artist="$track['artist']"
                        :duration="$track['time']"
                        data-track-id="{{ $track['id'] }}"
                        data-player-play="{{ $track['id'] }}"
                        data-player-queue="todas"
                    />
                </li>
            @endforeach
        </ul>
    </section>

    <p data-search-empty hidden class="mt-8 text-body text-ink-muted">No encontramos resultados. Prueba con otro título, artista o álbum.</p>
</x-layouts.app>
