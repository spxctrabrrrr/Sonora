<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Contracts\View\View;

class PlaylistController extends Controller
{
    public function __invoke(string $slug): View
    {
        $playlist = Catalog::playlist($slug) ?? abort(404);

        return view('playlist', [
            'playlist' => $playlist,
            'tracks' => Catalog::tracksOf($playlist),
        ]);
    }
}
