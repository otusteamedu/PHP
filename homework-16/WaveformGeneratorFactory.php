<?php

namespace App\Support\Waveform;

use FFMpeg\FFProbe;

class WaveformGeneratorFactory
{
    public static function make(string $temporaryDisk, string $filePath): WaveformGenerator
    {
        $ffprobe = FFProbe::create([
            'ffprobe.binaries' => config('media-library.ffprobe_path'),
        ]);
        $normalizer = new Normalizer();
        $temporaryFile = TemporaryFileFactory::make($temporaryDisk, $filePath);

        return new WaveformGenerator($ffprobe, $normalizer, $temporaryFile);
    }
}