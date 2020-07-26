<?php


namespace App\Services\Export\Diagrams\MapDiagrams;


interface Handbook
{
    public const MAP_COLORS = [
        '#994E2E',
        '#BA6C3B',
        '#CB7C44',
        '#DC8C4D',
        '#EE9D57',
        '#FDAE61',
        '#FEC06E',
        '#FEC77F'
    ];

    public const CIRCLE_COLORS = [
        '#EE903E',
        '#1882C8',
        '#FB7F4D',
        '#0A3E58',
        '#1A8E9D',
        '#33CCBF',
        '#AC3D11',
        '#2BCBFB',
        '#CB7C44',
        '#F0EB28',
        '#6FC93A',
        '#97A2B3'
    ];

    public const VALUES_COLOR_DISABLE = '#E0E0E0';
    public const VALUES_COLOR_ENABLE = '#FFA500';

    public const MAP_REGIONS_TEMPLATES_DIR_PATH = __DIR__ . '/MapRegionsTemplates/';
}
