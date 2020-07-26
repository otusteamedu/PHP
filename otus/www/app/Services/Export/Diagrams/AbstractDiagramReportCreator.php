<?php


namespace App\Services\Export\Diagrams;


abstract class AbstractDiagramReportCreator
{
    abstract protected function getReport(): ReportDiagrams;

    public function getReportDiagram()
    {
        $report = $this->getReport();
        return $report->getReportDiagram();
    }
}
