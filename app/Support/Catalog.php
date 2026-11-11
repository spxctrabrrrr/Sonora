<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Datos de ejemplo de Sonora (Puro Junior H, viejo). Sustituye a una base de datos:
 * si más adelante hay modelos, solo cambia el origen de estos métodos.
 */
class Catalog
{
    /** @return Collection<int, array<string, mixed>> */
    public static function tracks(): Collection
    {
        return collect([
            [1, 'Mente Positiva', 'Junior H', 'Atrapado En Un Sueño', 185, [45, 80, 60, 95, 50, 70]],
            [2, 'Ella', 'Junior H', "Cruisin' with Junior H", 202, [70, 40, 85, 55, 90, 35]],
            [3, 'Se Amerita', 'Junior H', "Cruisin' with Junior H", 194, [30, 65, 45, 80, 60, 75]],
            [4, 'El Azul', 'Junior H, Peso Pluma', 'El Azul', 188, [85, 50, 70, 35, 65, 90]],
            [5, 'Fin De Semana', 'Junior H, Oscar Maydon', 'Fin De Semana', 213, [55, 75, 90, 40, 80, 50]],
            [6, 'Extssy Model', 'Junior H', '$ad Boyz 4 Life', 175, [40, 60, 35, 85, 55, 70]],
            [7, 'Dias Nublados', 'Junior H', '$ad Boyz 4 Life', 241, [65, 90, 50, 70, 30, 80]],
            [8, '1004 Kilometros', 'Junior H', '$ad Boyz 4 Life', 198, [50, 35, 75, 60, 95, 45]],
            [9, 'Disfruto Lo Malo', 'Junior H, Natanael Cano', 'Corridos Tumbados', 182, [80, 55, 40, 90, 65, 35]],
            [10, 'Luna', 'Junior H', '$ad Boyz 4 Life II', 205, [35, 70, 85, 50, 75, 60]],
            [11, 'Y Lloro', 'Junior H', '$ad Boyz 4 Life II', 178, [60, 45, 70, 80, 40, 90]],
            [12, 'Volver Al Futuro', 'Junior H, Oscar Maydon', 'Volver Al Futuro', 181, [75, 85, 55, 65, 35, 50]],
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
            ['sad-boyz', 'Sad Boyz', 'Para pistear y llorarle a la tóxica con puros corridos tristes.', [2, 6, 7, 8, 10, 11], [40, 70, 55, 90, 35]],
            ['puros-tumbados', 'Puros Tumbados', 'Para prender el gallo y andar al cien.', [1, 3, 4, 5, 9, 12], [80, 45, 65, 30, 75]],
            ['ruta-belicona', 'Ruta Belicona', 'Para quemar llanta y que retumbe el bajo en la noche.', [3, 4, 7, 9, 12], [50, 85, 40, 70, 60]],
            ['los-exitos', 'Top del Junior', 'Las que no puedes dejar de repetir esta semana, puro fuego.', [4, 5, 7, 10, 11], [30, 60, 90, 50, 80]],
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

    public static function forScript(): array
    {
        return [
            'tracks' => self::tracks()->values()->all(),
            'playlists' => self::playlists()->mapWithKeys(fn (array $p): array => [$p['slug'] => $p['track_ids']])->all(),
        ];
    }

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