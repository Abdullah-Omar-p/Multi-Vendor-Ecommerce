<?php

namespace App\Http\Controllers;


use App\Models\Media;
use Illuminate\Support\Str;

class MediaController
{

    public static function saveMedia($request , $mimeType, $type, $model)
    {
        $categoriesFolder = public_path('media');
        $de = $request['media'];
        $imageName = Str::uuid($request['media']) . '.' . $de->getClientOriginalExtension();
        $de->move($categoriesFolder, $imageName);
        $image = config('app.url') . '/media/' . $imageName;
        Media::create([
            'filename' => $image,
            'mediaable_id' => $type->id,
            'mediaable_type' => $model,
            'type' => $mimeType,
        ]);
    }

    public static function updateMedia($request , $mimeType, $type, $model, $id)
    {
        $existingMedia = Media::where('mediaable_id', $id)->where('mediaable_type', $model)->first();
        if ($existingMedia) {
            $existingMediaPath = public_path('media') . '/' . basename($existingMedia->filename);
            if (file_exists($existingMediaPath)) {
                unlink($existingMediaPath);
            }
            $existingMedia->delete();
        }
        // Handle new media file
        $categoriesFolder = public_path('media');
        $de = $request['media'];
        $imageName = Str::uuid($request['media']) . '.' . $de->getClientOriginalExtension();
        $de->move($categoriesFolder, $imageName);
        $image = config('app.url') . '/media/' . $imageName;
        Media::create([
            'filename' => $image,
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
            $mediaPath = public_path('media') . '/' . basename($media->filename);
            if (file_exists($mediaPath)) {
                unlink($mediaPath);
            }
            $media->delete();
        }
    }
}
