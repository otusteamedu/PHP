<?php


namespace App\Services\Export\Diagrams\MapDiagrams;


use App\Services\AdvCampaigns\ActivityStatistic\SimpleReportPart;
use App\Services\Export\Diagrams\BaseDiagram;
use Illuminate\Support\Collection;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class Regions extends BaseDiagram
{

    private $document;


    public function __construct(SVGDocumentFragment $document)
    {
        $this->document = $document;
    }

    public function addRegions(\ArrayIterator $colorIterator, Collection $collection)
    {
        $collection->each(function (SimpleReportPart $item, $key) use ($colorIterator) {
            $templatePath = Handbook::MAP_REGIONS_TEMPLATES_DIR_PATH . $item->getCode() . '.svg';
            if (file_exists($templatePath)) {
                $svg = SVG::fromFile($templatePath);
                $template = $svg->getDocument();
                $this->addRegionsToSvg($template, $this->getColor($colorIterator));
            }
        });
    }

    private function addRegionsToSvg(SVGDocumentFragment $svg, $color)
    {
        $mapContainer = $this->document->getElementById('map-container');
        $cnt = $svg->countChildren();
        for ($i = 0; $i < $cnt; $i++) {
            $region = $svg->getChild(0);
            if ($region->getAttribute('class') === 'color') {
                $region->setStyle('fill', $color);
            }

            /** @noinspection NullPointerExceptionInspection */
            $mapContainer->addChild($region);
        }
    }
}
