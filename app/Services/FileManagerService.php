<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class FileManagerService
{
    public function upload(UploadedFile $file, $path = 'uploads', $fileName = null): false|string
    {
        try {
            if ($fileName == null) {
                $fileName = Str::random(10).time().'.'.$file->getClientOriginalExtension();
            }

            return Storage::url($file->storeAS($path, $fileName));

        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($filePath): bool
    {
        $success = true;
        try {
            if (! @unlink(Storage::url($filePath))) {
                $success = false;
            }
        } catch (\Exception $e) {
            $success = false;
        }

        return $success;
    }

    public function uploadPhoto($file, $path = 'uploads', $fileName = null, $ht = 960): string
    {
        if ($fileName == null) {
            $fileName = Str::random(10).time().'.jpg';
        }

        $image = ImageManager::gd()->read($file);

        if (! endsWith($path, '/')) {
            $path .= '/';
        }

        // resize for main image
        $height = $image->height() > $ht ? $ht : $image->height();
        $image->scale(null, $height)->toJpeg();
        Storage::put($path.$fileName, $image->encode());

        return Storage::url($path.$fileName);
    }

    public function uploadPhotoWithThumbnail($file, $path = 'uploads', $fileName = null): string
    {
        if ($fileName == null) {
            $fileName = Str::random(10).time().'.jpg';
        }

        $image = ImageManager::gd()->read($file);
        $originalImage = clone $image;

        if (! endsWith($path, '/')) {
            $path .= '/';
        }

        // resize for main image
        $height = $image->height() > 960 ? 960 : $image->height();
        $image->scale(null, $height)->toJpeg();
        Storage::put($path.$fileName, $image->encode());

        // save thumbnail
        $height = $originalImage->height() > 240 ? 240 : $originalImage->height();
        $originalImage->scale(null, $height)->toJpeg();
        Storage::put($path.'thumb-'.$fileName, $originalImage->encode());

        return Storage::url($path.$fileName);
    }

    public function downloadAsZip(string $zipPath, $files): JsonResponse|BinaryFileResponse
    {
        $zip = new ZipArchive;

        // Open ZIP file for writing
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Unable to create ZIP file'], 500);
        }

        $filesystem = Storage::disk(config('filesystems.default'));
        $isCloud = in_array(config('filesystems.default'), ['s3', 'azure', 'gcs']);
        foreach ($files as $file) {
            if (! $filesystem->exists(getRelativeUrl($file))) {
                continue;
            }

            if ($isCloud) {
                // Get the file content from cloud storage
                $stream = $filesystem->readStream($file);
                if ($stream) {
                    $content = stream_get_contents($stream);
                    fclose($stream);
                    $zip->addFromString(basename($file), $content);
                }
            } else {
                // Add file from local storage
                $path = $filesystem->path($file);
                $zip->addFile($path, basename($file));
            }
        }
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
