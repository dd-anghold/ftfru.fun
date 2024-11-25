<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\ids;

class HomeController extends Controller
{
    public function index(Request $Request)
    {
        $steamId = ids::orderBy('id', 'ASC')->get('steamid')->pluck('steamid')->implode(',');
        $streamIds = ids::orderBy('id', 'ASC')->pluck('streamid')->toArray();
        $teamspeakid = ids::orderBy('id', 'ASC')->pluck('teamspeakid')->toArray();

        return Inertia::render('Index', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'playerData' => $steamId,
            'streamIds' => $streamIds,
            'teamspeakid' => $teamspeakid,
        ]);
    }
}
