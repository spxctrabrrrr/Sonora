<x-layouts.app title="Tu biblioteca">
    <h1 class="text-title">Tu biblioteca</h1>
    <p class="mt-1 font-mono text-mono text-ink-muted">{{ $playlists->count() }} playlists</p>

    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
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
</x-layouts.app>
