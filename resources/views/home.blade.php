<x-layouts.app title="Inicio">
    <div data-chip-group role="group" aria-label="Filtrar contenido" class="mb-6 flex flex-wrap gap-2">
        <x-chip data-filter="todo" :pressed="true">Todo</x-chip>
        <x-chip data-filter="playlists">Playlists</x-chip>
        <x-chip data-filter="canciones">Canciones</x-chip>
    </div>

    <h1 class="text-title">Qué escuchar hoy</h1>

    <section data-section="playlists" aria-labelledby="titulo-playlists" class="mt-8">
        <h2 id="titulo-playlists" class="mb-4 text-heading">Tus playlists</h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($playlists as $playlist)
                <x-media-card
                    :href="route('playlists.show', $playlist['slug'])"
                    :title="$playlist['name']"
                    :meta="$playlist['count'].' canciones'"
                    :time="$playlist['time']"
                    :bars="$playlist['bars']"
                />
            @endforeach
        </div>
    </section>

    <section data-section="canciones" aria-labelledby="titulo-canciones" class="mt-8">
        <h2 id="titulo-canciones" class="mb-4 text-heading">Seguir escuchando</h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($tracks as $track)
                <x-media-card
                    data-player-play="{{ $track['id'] }}"
                    data-player-queue="todas"
                    :title="$track['title']"
                    :meta="$track['artist']"
                    :time="$track['time']"
                    :bars="$track['bars']"
                />
            @endforeach
        </div>
    </section>
</x-layouts.app>
