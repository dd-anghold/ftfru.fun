<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\TeamspeakController;
use App\Models\ids;

Route::get('/', function () {
    $steamId = ids::orderBy('id', 'ASC')->get('steamid')->pluck('steamid')->implode(',');
    $streamIds = ids::orderBy('id', 'ASC')->pluck('streamid')->toArray();
    return Inertia::render('Index', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'playerData' => $steamId,
        'streamIds' => $streamIds
    ]);
})->name('index');


Route::get('/streams/{streamid}', function (Request $Request) {
    return Inertia::render('Stream', [
        'streamid' => $Request->streamid
    ]);
})->name('stream');

Route::get('/streams', function (Request $Request) {
    $streamid = ids::get('streamid');

    return Inertia::render('Streams', [
        'streamid' => $streamid,
    ]);
})->name('streams');

Route::get('/teamspeak/online-users', [TeamspeakController::class, 'getChannelsAndUsers'])->name('getChannelsAndUsers');
Route::get('/teamspeak/channels', [TeamSpeakController::class, 'getChannels'])->name('getChannels');
Route::get('/teamspeak/clients', [TeamSpeakController::class, 'getClients'])->name('getClients');

Route::get('/teamspeak/list', function () {
    return Inertia::render('TeamSpeakList');
})->name('teamspeakList');

Route::get('/teamspeak', function () {
    return Inertia::render('TeamSpeak');
})->name('teamspeak');
