<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StreamsController;
use App\Http\Controllers\TeamspeakController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/streams/{streamid}',[StreamsController::class, 'stream'] )->name('stream');
Route::get('/streams',[StreamsController::class, 'streams'] )->name('streams');

Route::get('/teamspeak/online-users', [TeamspeakController::class, 'getChannelsAndUsers'])->name('getChannelsAndUsers');
Route::get('/teamspeak/users-with-channels', [TeamspeakController::class, 'getUsersWithChannelNames'])->name('getUsersWithChannelNames');
Route::get('/teamspeak/list', [TeamspeakController::class, 'List'])->name('teamspeakList');