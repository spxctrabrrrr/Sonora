<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Contracts\View\View;

class SearchController extends Controller
{
    public function __invoke(): View
    {
        return view('search', [
            'playlists' => Catalog::playlists(),
            'tracks' => Catalog::tracks(),
        ]);
    }
}
