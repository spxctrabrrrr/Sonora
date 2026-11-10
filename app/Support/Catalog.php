<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Datos de ejemplo de Sonora (todo inventado). Sustituye a una base de datos:
 * si más adelante hay modelos, solo cambia el origen de estos métodos.
 */
class Catalog
{
    /** @return Collection<int, array<string, mixed>> */
    public static function tracks(): Collection
    {
        return collect([
            [1, 'Corriente tibia', 'Faro Dormido', 'Mapa de sal', 214, [45, 80, 60, 95, 50, 70]],
            [2, 'Pasos en el techo', 'Ciruela Lunar', 'Ventanas bajas', 252, [70, 40, 85, 55, 90, 35]],
            [3, 'Ciudad de lana', 'Ala de Papel', 'Domingo largo', 198, [30, 65, 45, 80, 60, 75]],
            [4, 'Tren de las seis', 'Hierba Alta', 'Tierra tibia', 276, [85, 50, 70, 35, 65, 90]],
            [5, 'Lámparas', 'Nube Tres', 'Luz de tarde', 187, [55, 75, 90, 40, 80, 50]],
            [6, 'Eco de pasillo', 'Coro Hueco', 'Ecos de pasillo', 231, [40, 60, 35, 85, 55, 70]],
            [7, 'Sal y limón', 'Faro Dormido', 'Mapa de sal', 243, [65, 90, 50, 70, 30, 80]],
            [8, 'Mapa del insomnio', 'Ciruela Lunar', 'Ventanas bajas', 265, [50, 35, 75, 60, 95, 45]],
            [9, 'Casa sin reloj', 'Ala de Papel', 'Domingo largo', 222, [80, 55, 40, 90, 65, 35]],
            [10, 'Verano en pausa', 'Hierba Alta', 'Tierra tibia', 209, [35, 70, 85, 50, 75, 60]],
            [11, 'Orilla', 'Nube Tres', 'Luz de tarde', 174, [60, 45, 70, 80, 40, 90]],
            [12, 'Cuaderno azul', 'Coro Hueco', 'Ecos de pasillo', 258, [75, 85, 55, 65, 35, 50]],
        ])->map(fn (array $t): array => [
            'id' => $t[0],
            'title' => $t[1],
            'artist' => $t[2],
            'album' => $t[3],
            'seconds' => $t[4],
            'time' => self::format($t[4]),
            'bars' => $t[5],
        ]);
    }

    /** @return Collection<int, array<string, mixed>> */
    public static function playlists(): Collection
    {
        $tracks = self::tracks()->keyBy('id');

        return collect([
            ['tardes-lentas', 'Tardes lentas', 'Canciones tranquilas para bajar el ritmo después de comer.', [1, 3, 5, 9, 10, 11], [40, 70, 55, 90, 35]],
            ['para-concentrarte', 'Para concentrarte', 'Sonidos suaves y constantes para estudiar o trabajar sin distracciones.', [2, 4, 6, 8, 12], [80, 45, 65, 30, 75]],
            ['ruta-de-noche', 'Ruta de noche', 'Para el camino a casa cuando ya oscureció.', [4, 7, 8, 12, 2], [50, 85, 40, 70, 60]],
            ['en-bucle', 'En bucle', 'Las que no puedes dejar de repetir esta semana.', [7, 1, 5, 9, 3], [30, 60, 90, 50, 80]],
        ])->map(function (array $p) use ($tracks): array {
            $seconds = collect($p[3])->sum(fn (int $id): int => $tracks[$id]['seconds']);

            return [
                'slug' => $p[0],
                'name' => $p[1],
                'description' => $p[2],
                'track_ids' => $p[3],
                'bars' => $p[4],
                'count' => count($p[3]),
                'seconds' => $seconds,
                'time' => self::format($seconds),
            ];
        });
    }

    /** @return array<string, mixed>|null */
    public static function playlist(string $slug): ?array
    {
        return self::playlists()->firstWhere('slug', $slug);
    }

    /** @return Collection<int, array<string, mixed>> */
    public static function tracksOf(array $playlist): Collection
    {
        $tracks = self::tracks()->keyBy('id');

        return collect($playlist['track_ids'])->map(fn (int $id): array => $tracks[$id]);
    }

    /** Datos que el reproductor simulado necesita en JavaScript. */
    public static function forScript(): array
    {
        return [
            'tracks' => self::tracks()->values()->all(),
            'playlists' => self::playlists()->mapWithKeys(fn (array $p): array => [$p['slug'] => $p['track_ids']])->all(),
        ];
    }

    /** 04:18 para menos de una hora, 1:12:40 para más. */
    public static function format(int $seconds): string
    {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $rest = $seconds % 60;

        return $hours > 0
            ? sprintf('%d:%02d:%02d', $hours, $minutes, $rest)
            : sprintf('%02d:%02d', $minutes, $rest);
    }
}
