<?php

namespace App\Support\Waveform;

use FFMpeg\FFProbe;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class WaveformGenerator
{
    private TemporaryFile $file;

    private NormalizerContract $normalizer;

    private FFProbe $FFProbe;

    private array $data = [];

    public function __construct(FFProbe $FFProbe, NormalizerContract $normalizer, TemporaryFile $file)
    {
        $this->FFProbe    = $FFProbe;
        $this->normalizer = $normalizer;
        $this->file       = $file;
    }

    public function generate(): self
    {
        $process = Process::fromShellCommandline(config('media-library.ffmpeg_path') .
                                                 ' -i ' . $this->file->getPath() . ' -f wav - | ' .
                                                 config('media-library.waveform_path') .
                                                 ' --input-format wav' .
                                                 ' --output-format json' .
                                                 ' --bits 8' .
                                                 ' --pixels-per-second ' . $this->countPixelsPerSecond());
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->data = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);

        return $this;
    }

    public function normalize(): self
    {
        $this->normalizer->normalize($this->data);

        return $this;
    }

    private function countPixelsPerSecond(): int
    {
        return (int) ceil(320 / $this->getDuration());
    }

    private function getDuration(): float
    {
        return (float) $this->FFProbe->format($this->file->getPath())
                                     ->get('duration');
    }

    public function getData(): array
    {
        return $this->data;
    }
}