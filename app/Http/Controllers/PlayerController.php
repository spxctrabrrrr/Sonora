<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Contracts\View\View;

class PlayerController extends Controller
{
    public function __invoke(): View
    {
        return view('player', ['track' => Catalog::tracks()->first()]);
    }
}
