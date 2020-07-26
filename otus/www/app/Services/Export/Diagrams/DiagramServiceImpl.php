<?php


namespace App\Services\Export\Diagrams;


use App\Services\AdvCampaigns\ActivityStatistic\PartsReport;
use App\Services\AdvCampaigns\ActivityStatistic\ReportPart;


class DiagramServiceImpl implements DiagramService
{
    private $diagramExporter;

    public function __construct(DiagramExporter $diagramExporter)
    {
        $this->diagramExporter = $diagramExporter;
    }

    public function getDiagram(string $type, PartsReport $partsReport)
    {
        $reportDiagrams = null;
        $sortedPartsReport = $this->getSortedPartsReport($partsReport);

        switch ($type) {
            case 'share':
                $reportDiagrams = new CircleReportCreator($sortedPartsReport, $this->diagramExporter);
                break;
            case 'share-map':
                $reportDiagrams = new ShareMapReportCreator($sortedPartsReport, $this->diagramExporter);
                break;
            case 'values-map':
                $reportDiagrams = new ValuesMapReportCreator($sortedPartsReport, $this->diagramExporter);
                break;
        }

        if (!$reportDiagrams) {
            throw new \RuntimeException('undefined diagram class');
        }

        return $reportDiagrams->getReportDiagram();
    }

    private function getSortedPartsReport(PartsReport $partsReport)
    {
        $sortedPartCollection = $partsReport->getParts()->sortByDesc(static function (ReportPart $reportPart) {
            return (int)$reportPart->getValue();
        })->values();

        $modifiedPartReport = new PartsReport($partsReport->getType(), $partsReport->getTitle(), $partsReport->getTotal());
        $modifiedPartReport->addParts($sortedPartCollection);

        return $modifiedPartReport;
    }
}
