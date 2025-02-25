<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{

    public function uploadFile(UploadedFile $file, string $directory = 'uploads'): string
    {
        try {
            $filename = 'merchant_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // move the file to storage
            $file->storeAs($directory, $filename, 'public');

            return '/storage/' . $directory . '/' . $filename; // Perbaiki path di sini
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function deleteFile(?string $path): bool
    {

        $filePath = str_replace('/storage/', '', $path);

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return true;
        }
        return false;
    }
}
