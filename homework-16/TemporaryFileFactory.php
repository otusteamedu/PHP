<?php

namespace App\Support\Waveform;

use Illuminate\Support\Facades\Storage;

class TemporaryFileFactory
{
    public static function make(string $temporaryDisk, string $filePath): TemporaryFile
    {
        if (! Storage::disk($temporaryDisk)->exists($filePath)) {
            $mediaDisk = config('media-library.disk_name');
            $stream    = Storage::disk($mediaDisk)->readStream($filePath);
            Storage::disk($temporaryDisk)->writeStream($filePath, $stream);
        }

        return new TemporaryFile(
            $temporaryDisk,
            Storage::disk($temporaryDisk)->path($filePath)
        );
    }
}