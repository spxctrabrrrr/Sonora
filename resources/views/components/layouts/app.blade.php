@props(['title' => null, 'shell' => true, 'barAccent' => true])

@php($catalog = \App\Support\Catalog::forScript())

<!DOCTYPE html>
<html lang="es" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ? $title.' · Sonora' : 'Sonora' }}</title>

        {{-- Aplica el tema guardado antes de pintar, para evitar un parpadeo --}}
        <script>
            try {
                var saved = localStorage.getItem('sonora:theme');
                if (saved === 'light' || saved === 'dark') document.documentElement.dataset.theme = saved;
            } catch (e) {}
        </script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>window.sonora = @json($catalog);</script>
    </head>
    <body>
        <a href="#contenido" class="sr-only rounded-pill bg-surface-high px-4 py-3 text-body-sm font-bold text-ink focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50">Saltar al contenido</a>

        @if ($shell)
            <div class="flex h-dvh flex-col md:grid md:grid-cols-[200px_1fr] md:grid-rows-[minmax(0,1fr)_80px]">
                <nav aria-label="Principal" class="order-3 flex border-t border-line bg-surface-raised md:order-none md:col-start-1 md:row-start-1 md:flex-col md:gap-2 md:border-t-0 md:px-4 md:py-6">
                    <x-logo class="mb-6 hidden md:flex" />
                    <x-nav-link :href="route('home')" icon="home" :active="request()->routeIs('home')">Inicio</x-nav-link>
                    <x-nav-link :href="route('search')" icon="search" :active="request()->routeIs('search')">Buscar</x-nav-link>
                    <x-nav-link :href="route('library')" icon="library" :active="request()->routeIs('library', 'playlists.*')">Tu biblioteca</x-nav-link>
                    <div class="mt-auto hidden md:block">
                        <x-button variant="ghost" class="w-full" data-theme-toggle><span data-theme-label>Usar tema claro</span></x-button>
                    </div>
                </nav>

                <main id="contenido" tabindex="-1" class="order-1 min-h-0 flex-1 overflow-y-auto p-4 md:order-none md:col-start-2 md:row-start-1 md:p-8">
                    <div class="mb-4 flex justify-end md:hidden">
                        <x-button variant="ghost" data-theme-toggle><span data-theme-label>Usar tema claro</span></x-button>
                    </div>
                    {{ $slot }}
                </main>

                <x-player-bar :accent="$barAccent" class="order-2 md:order-none md:col-span-2 md:row-start-2" />
            </div>
        @else
            <main id="contenido" tabindex="-1" class="min-h-dvh">
                {{ $slot }}
            </main>
        @endif
    </body>
</html>
