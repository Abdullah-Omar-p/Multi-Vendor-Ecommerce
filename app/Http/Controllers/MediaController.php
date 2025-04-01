<?php

namespace App\Http\Controllers;


use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaController
{

    public static function saveMedia($request, $mimeType, $type, $model)
    {
        $de = $request['media'];
        $imageName = Str::uuid($request['media']) . '.' . $de->getClientOriginalExtension();
        $path = $de->storeAs('media', $imageName);
        $imageUrl = Storage::url($path);
        Media::create([
            'filename' => $imageUrl,
            'mediaable_id' => $type->id,
            'mediaable_type' => $model,
            'type' => $mimeType,
        ]);
    }

    public static function updateMedia($request, $mimeType, $type, $model, $id)
    {
        $existingMedia = Media::where('mediaable_id', $id)->where('mediaable_type', $model)->first();
        if ($existingMedia) {
            $filePath = 'media/' . basename($existingMedia->filename);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            $existingMedia->delete();
        }
        // Handle new media file
        $de = $request['media'];
        $imageName = Str::uuid($request['media']) . '.' . $de->getClientOriginalExtension();
        $path = $de->storeAs('media', $imageName);
        $imageUrl = Storage::url($path);
        Media::create([
            'filename' => $imageUrl,
            'mediaable_id' => $type->id,
            'mediaable_type' => $model,
            'type' => $mimeType,
        ]);
    }

    public static function removeMedia($modelId, $modelType)
    {
        $mediaItems = Media::where('mediaable_id', $modelId)
            ->where('mediaable_type', $modelType)
            ->get();

        foreach ($mediaItems as $media) {
            $filePath = 'media/' . basename($media->filename);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            $media->delete();
        }
    }
}


/*
   --->> When U Use This Class In Other Project Change This in Config/filesystems.php
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/media'),
            'url' => env('APP_URL').'/storage/media',
            'visibility' => 'public',
            'throw' => false,
        ],

        php artisan storage:link  # Creates the symbolic link from public/storage to storage/app/public
*/
