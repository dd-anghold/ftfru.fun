<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\ids;

Route::get('/', function () {
    $apiKey = '39EA90A863FC233C9868C29FF3591B68';
    $steamId = ids::get('steamid')->pluck('steamid')->implode(','); // Предполагая, что 'steamid' - это поле

    return Inertia::render('Welcome', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'playerData' => $steamId,
    ]);
})->name('index');


Route::get('/stream/{streamid}', function (Request $Request) {
    return Inertia::render('Stream', [
        'streamid' => $Request->streamid
    ]);
})->name('stream');

Route::get('/streams', function (Request $Request) {
    $streamid = ids::get('streamid');

    return Inertia::render('Streams', [
        'streamid' => $streamid
    ]);
})->name('streams');
