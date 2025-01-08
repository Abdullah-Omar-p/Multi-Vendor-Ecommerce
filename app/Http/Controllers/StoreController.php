<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // Store Media
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mp3|max:10240',
        ]);

        $file = $request->file('media');
        $filePath = $file->store('media');
        $media = Media::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'type' => $file->getMimeType(),
        ]);

        return response()->json(['success' => true, 'media' => $media]);
    }

    // Get Media
    public function show($id)
    {
        $media = Media::findOrFail($id);
        return response()->json(['success' => true, 'media' => $media]);
    }

    // Edit Media
    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        if ($request->hasFile('media')) {
            $request->validate([
                'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mp3|max:10240',
            ]);

            // Delete old file
            Storage::delete($media->file_path);

            // Store new file
            $file = $request->file('media');
            $filePath = $file->store('media');

            // Update database record
            $media->update([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'type' => $file->getMimeType(),
            ]);
        }

        return response()->json(['success' => true, 'media' => $media]);
    }

    // Delete Media
    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // Delete file from storage
        Storage::delete($media->file_path);

        // Delete record from database
        $media->delete();

        return response()->json(['success' => true]);
    }
}
