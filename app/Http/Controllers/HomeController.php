<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'playlists' => Catalog::playlists(),
            'tracks' => Catalog::tracks()->take(8),
        ]);
    }
}
