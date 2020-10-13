<?php

namespace App\Support;

use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Throwable;

class WaveformGenerator
{
    private const TEMPORARY_DISK = 'tmp';

    private string $mediaDisk;

    private FFProbe $ffprobe;

    public function __construct()
    {
        $this->mediaDisk = config('media-library.disk_name');

        $this->ffprobe = FFProbe::create([
            'ffprobe.binaries' => config('media-library.ffprobe_path'),
        ]);
    }

    /**
     * @return static
     */
    public static function make()
    {
        return new static();
    }

    /**
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media $media
     *
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function generateFor(Media $media): void
    {
        if (! Storage::disk(self::TEMPORARY_DISK)->exists($media->getPath())) {
            $stream = Storage::disk($this->mediaDisk)->readStream($media->getPath());
            Storage::disk(self::TEMPORARY_DISK)->writeStream($media->getPath(), $stream);
        }

        $temporaryFile = Storage::disk(self::TEMPORARY_DISK)->path($media->getPath());

        try {
            if ($waveform = $this->generateWaveformData($temporaryFile)) {
                $media->setCustomProperty('waveform', $waveform);
                $media->save();
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        } finally {
            Storage::disk(self::TEMPORARY_DISK)->delete($media->getPath());
        }
    }

    /**
     * @param string $file
     *
     * @throws \JsonException
     * @return array
     */
    public function generateWaveformData(string $file): array
    {
        $process = Process::fromShellCommandline(config('media-library.ffmpeg_path') .
                                                 ' -i ' . $file . ' -f wav - | ' .
                                                 config('media-library.waveform_path') .
                                                 ' --input-format wav' .
                                                 ' --output-format json' .
                                                 ' --bits 8' .
                                                 ' --pixels-per-second ' . $this->countPixelsPerSecond($file));
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $rawData = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);

        return $this->normalizeData($rawData);
    }

    /**
     * @param string $filePath
     *
     * @return int
     */
    private function countPixelsPerSecond(string $filePath): int
    {
        return (int) ceil(320 / $this->getDuration($filePath));
    }

    /**
     * @param string $filePath
     *
     * @return float
     */
    private function getDuration(string $filePath): float
    {
        return (float) $this->ffprobe->format($filePath)->get('duration');
    }

    private function normalizeData(array $waveform): array
    {
        $maxValue       = max($waveform['data']);
        $normalizedData = [];
        foreach ($waveform['data'] as $value) {
            $normalizedData[] = round($value / $maxValue, 2);
        }

        $waveform['data'] = $normalizedData;

        return $waveform;
    }
}
