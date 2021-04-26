<?php


namespace v2\Helpers;


class DistanceUnits
{
    public const KM = 'km';
    public const M = 'mi';
    public const NM = 'nm';

    public static function convert(float $value, string $unit) : float
    {
        switch (strtoupper($unit)){
            case self::KM : return ($value * 1.609344);
            case self::NM : return ($value * 0.8684);
            default: return $value;
        }
    }
}