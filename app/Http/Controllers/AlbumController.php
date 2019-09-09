<?php

namespace App\Http\Controllers;

use App\Album;
use App\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $albums = Album::where('user_id', $user->id)->get();

        foreach ($albums as $album) {
            $album['latestPhoto'] = Photo::where('album_id', $album->id)->latest()->first();
        }

        return response()->json($albums, 200);
    }

    public function store(Request $request)
    {
        $album = new Album();
        $album->user_id = Auth::id();
        $album->title = $request->title;
        $album->desc = $request->desc;
        $album->save();

        return response()->json($album, 200);
    }

    public function show($id)
    {
        $album = Album::with('photos')->where('id', $id)->first();

        return response()->json($album, 200);
    }
}
