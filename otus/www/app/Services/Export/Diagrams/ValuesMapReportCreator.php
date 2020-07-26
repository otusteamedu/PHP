<?php

namespace App\Services\Export\Diagrams;

use App\Services\AdvCampaigns\ActivityStatistic\PartsReport;
use App\Services\Export\Diagrams\MapDiagrams\ValuesMapDiagram;


class ValuesMapReportCreator extends AbstractDiagramReportCreator
{
    private $partsReport;
    private $diagramExporter;

    public function __construct(PartsReport $partsReport, DiagramExporter $diagramExporter)
    {
        $this->partsReport = $partsReport;
        $this->diagramExporter = $diagramExporter;
    }

    public function getReport(): ReportDiagrams
    {
        return new ValuesMapDiagram($this->partsReport, $this->diagramExporter);
    }
}
