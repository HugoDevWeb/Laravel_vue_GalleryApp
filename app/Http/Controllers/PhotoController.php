<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function download($id)
    {
        $photo = Photo::find($id);
        return Storage::download($photo->path);
    }

    public function store(Request $request)
    {
        $ext = $request->file('items')->getClientOriginalExtension();
        $filename = Str::random(32). '.' . $ext;
        $file = $request->file('items');
        $path = Storage::disk('local')->putFileAs('public/images/photos', $file, $filename);

        $photo = new Photo();
        $photo->album_id = $request->album_id;
        $photo->caption = $request->caption;
        $photo->extension = $ext;
        $photo->path = $path . '.' . $ext;
        $photo->mime = $file->getClientMimeType();
        $photo->file_name = $filename;
        $photo->save();

        return response()->json($photo, 200);
    }
}
