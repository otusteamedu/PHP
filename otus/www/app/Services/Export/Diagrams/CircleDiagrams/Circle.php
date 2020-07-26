<?php


namespace App\Services\Export\Diagrams\CircleDiagrams;


use App\Services\AdvCampaigns\ActivityStatistic\SimpleReportPart;
use App\Services\Export\Diagrams\BaseDiagram;
use ArrayIterator;
use Illuminate\Support\Collection;
use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Structures\SVGDocumentFragment;

class Circle extends BaseDiagram
{
    private const CIRCLE_LENGTH = 628;
    private const CIRCLE_PART_LENGTH = self::CIRCLE_LENGTH / 100;
    private $startOffset = 0;

    private $circleCenterCx = 230;
    private $circleCenterCy = 215;
    private $diagramRadius = 100;

    private $parts;
    private $document;

    public function __construct(Collection $parts, SVGDocumentFragment $document)
    {
        $this->parts = $parts;
        $this->document = $document;
    }

    public function addCircleDiagram(ArrayIterator $colorIterator)
    {
        $parts = $this->getDiagramParts();
        $parts->each(function ($part) use ($colorIterator) {

            $partLength = self::CIRCLE_PART_LENGTH * $part;
            $dasharray = [
                abs($partLength),
                abs(self::CIRCLE_LENGTH - $partLength)
            ];

            $strokeDasharray = abs($dasharray[0] - 2) . ',' . abs($dasharray[1] + 2);

            $strokeDashoffset = $this->getDashOffset($partLength);
            $circlePart = $this->getDiagramCirclePart($strokeDasharray, $strokeDashoffset, $this->getColor($colorIterator));

            $this->document->addChild($circlePart);
        });
    }

    private function getDashOffset (float $partLength) {
        $result = self::CIRCLE_LENGTH - $this->startOffset;
        $this->startOffset += $partLength;
        return $result;
    }

    private function getDiagramCirclePart($strokeDasharray, $strokeDashoffset, $stroke)
    {

        $circle = new SVGCircle($this->circleCenterCx, $this->circleCenterCy, $this->diagramRadius);

        $circle->setStyle('stroke-width', '40');
        $circle->setAttribute('transform', $this->getTransformRotate());
        $circle->setStyle('fill', 'none');
        $circle->setStyle('stroke-dasharray', $strokeDasharray);
        $circle->setStyle('stroke-dashoffset', $strokeDashoffset);
        $circle->setStyle('stroke', $stroke);
        return $circle;
    }

    private function getTransformRotate() {
        return sprintf('rotate(-90 %s %s)', $this->circleCenterCx, $this->circleCenterCy);
    }

    private function getDiagramParts()
    {
        $percent = $this->getPercent();
        return $this->parts->map(static function (SimpleReportPart $simpleReportPart) use ($percent) {
            return $simpleReportPart->getValue() / $percent;
        });
    }

    private function getPercent()
    {
        $totalSum = $this->getTotalSum();
        return $totalSum / 100;
    }

    private function getTotalSum()
    {
        return $this->parts->sum(static function (SimpleReportPart $simpleReportPart) {
            return $simpleReportPart->getValue();
        });
    }
}
