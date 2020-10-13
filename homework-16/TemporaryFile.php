<?php

namespace App\Support\Waveform;

use Illuminate\Support\Facades\Storage;

class TemporaryFile
{
    protected string $disk;
    protected string $path;

    public function __construct(string $disk, string $path)
    {
        $this->disk = $disk;
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function delete(): bool
    {
        return Storage::disk($this->disk)->delete($this->path);
    }
}