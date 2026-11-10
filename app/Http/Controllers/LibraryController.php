<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Contracts\View\View;

class LibraryController extends Controller
{
    public function __invoke(): View
    {
        return view('library', ['playlists' => Catalog::playlists()]);
    }
}
