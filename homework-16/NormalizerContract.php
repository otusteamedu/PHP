<?php

namespace App\Support\Waveform;

interface NormalizerContract
{
    public function normalize(array $waveform): array;
}