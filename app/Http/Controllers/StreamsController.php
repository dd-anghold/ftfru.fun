<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\ids;

class StreamsController extends Controller
{
    public function streams(Request $request){
        $streamid = ids::get('streamid');

        return Inertia::render('Streams', [
            'streamid' => $streamid,
        ]);
    }

    public function stream(Request $request){
        $streamid = $request->streamid;
        return Inertia::render('Stream', [
            'streamid' => $streamid,
        ]);
    }
}
