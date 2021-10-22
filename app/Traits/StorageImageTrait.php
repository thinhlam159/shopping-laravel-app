<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StorageImageTrait
{
    public function storageTraitUpload($request, $fieldName, $storeFolder)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHast = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $filePath = $request->file($fieldName)->storeAs('public/' . $storeFolder . '/' . auth()->id(), $fileNameHast);
            $dataUploads = [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($filePath)
            ];
            return $dataUploads;
        }
        return null;
    }

    public function storageTraitImage($file, $storeFolder)
    {
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHast = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/' . $storeFolder . '/' . auth()->id(), $fileNameHast);
        $dataUploads = [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($filePath)
        ];
        return $dataUploads;
    }
}
