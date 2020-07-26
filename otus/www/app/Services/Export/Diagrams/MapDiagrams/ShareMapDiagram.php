<?php


namespace App\Services\Export\Diagrams\MapDiagrams;


use App\Services\AdvCampaigns\ActivityStatistic\PartsReport;
use App\Services\Export\Diagrams\BaseDiagram;
use App\Services\Export\Diagrams\DescriptionBuilder;
use App\Services\Export\Diagrams\DiagramExporter;
use App\Services\Export\Diagrams\DiagramResponseBuilder;
use App\Services\Export\Diagrams\DiagramSvgElementsGetterTrait;
use App\Services\Export\Diagrams\ReportDiagrams;
use ArrayIterator;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class ShareMapDiagram extends BaseDiagram implements ReportDiagrams
{
    use DiagramSvgElementsGetterTrait;

    private const MAP_SVG_TEMPLATE_PATH = __DIR__ . '/map-chart.svg';

    private $partsReport;
    private $maxTitleLength = 45;
    private $titleOffsetX = 32;
    private $titleOffsetY = 42;

    private $diagramExporter;

    public function __construct(PartsReport $partsReport, DiagramExporter $diagramExporter)
    {
        $this->partsReport = $partsReport;
        $this->diagramExporter = $diagramExporter;
    }

    public function getReportDiagram()
    {

        $image = SVG::fromFile(self::MAP_SVG_TEMPLATE_PATH);
        $doc = $image->getDocument();
        $colorIterator = new ArrayIterator(Handbook::MAP_COLORS);

        $this->getHeader($doc);

        /** @var Regions $regions */
        $regions = app()->makeWith(Regions::class, ['document' => $doc]);

        $formattedCollection = $this->getMapFormattedCollection($this->partsReport->getParts());
        $regions->addRegions($colorIterator, $formattedCollection);

        $this->addDescription($doc, $colorIterator);

        $filePath = $this->diagramExporter->exportToPng($image, $this->getFileName($this->partsReport->getTitle()));
        /** @var DiagramResponseBuilder $responseBuilder */
        /** @noinspection PhpUnhandledExceptionInspection */
        $responseBuilder = app()->make(DiagramResponseBuilder::class);
        return $responseBuilder
            ->setFilePath($filePath)
            ->setWidth($doc->getWidth())
            ->setHeight($doc->getHeight())
            ->build();
    }


    private function addDescription(SVGDocumentFragment $document, ArrayIterator $colorIterator)
    {
        /** @var DescriptionBuilder $descriptionBuilder */
        /** @noinspection PhpUnhandledExceptionInspection */
        $descriptionBuilder = app()->make(DescriptionBuilder::class);
        $formattedParts = $this->getMapFormattedCollection($this->partsReport->getParts());

        $descriptionBuilder
            ->setTextOffsetX(686)
            ->setTextOffsetY(84)
            ->setValueOffsetX(877)
            ->setValueOffsetY(84)
            ->setCircleOffsetX(670)
            ->setCircleOffsetY(80)
            ->setCircleRadius(6)
            ->setOffsetYStep(28)
            ->setParts($formattedParts)
            ->setDocument($document)
            ->setMaxTextLength(31)
            ->setHorizontalLineHeight(1)
            ->setHorizontalLineWidth(318)
            ->setHorizontalLineColor('#E7E7E7')
            ->setTotalText('Итого');

        $description = $descriptionBuilder->build();
        $description->addDescriptions($colorIterator);
    }

    private function getHeader(SVGDocumentFragment $doc)
    {
        $title = $this->partsReport->getTitle();

        if (mb_strlen($title) > $this->maxTitleLength) {
            $title = mb_substr($title, 0, $this->maxTitleLength) . '...';
        }

        $title = $this->getTitleText($title, $this->titleOffsetX, $this->titleOffsetY);
        $doc->addChild($title);
    }
}
