<?php

namespace App\Support\Waveform;

class Normalizer implements NormalizerContract
{
    public function normalize(array $waveform): array
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