<?php


namespace App\Services\Export\Diagrams;


use SVG\SVG;

interface DiagramExporter
{
    public function exportToSvg(SVG $svg, string $title);

    public function exportToPng(SVG $svg, string $title);
}
