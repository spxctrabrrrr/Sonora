<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/buscar', SearchController::class)->name('search');
Route::get('/biblioteca', LibraryController::class)->name('library');
Route::get('/playlists/{slug}', PlaylistController::class)->name('playlists.show');
Route::get('/reproductor', PlayerController::class)->name('player');
