<?php


namespace App\Services\Export\Diagrams;


use App\Services\AdvCampaigns\ActivityStatistic\PartsReport;


interface DiagramService
{
    public function getDiagram(string $type, PartsReport $partsReport);
}
