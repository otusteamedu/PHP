<?php


namespace App\Services\Export\Diagrams\MapDiagrams;


use App\Services\AdvCampaigns\ActivityStatistic\PartsReport;
use App\Services\AdvCampaigns\ActivityStatistic\SharesReportPart;
use App\Services\AdvCampaigns\ActivityStatistic\SimpleReportPart;
use App\Services\Export\Diagrams\BaseDiagram;
use App\Services\Export\Diagrams\DescriptionBuilder;
use App\Services\Export\Diagrams\DiagramExporter;
use App\Services\Export\Diagrams\DiagramResponseBuilder;
use App\Services\Export\Diagrams\DiagramSvgElementsGetterTrait;
use App\Services\Export\Diagrams\ReportDiagrams;
use ArrayIterator;
use Illuminate\Support\Collection;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class ValuesMapDiagram extends BaseDiagram implements ReportDiagrams
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
        $formattedParts = $this->getValuesMapFormattedCollection($this->partsReport->getParts());

        $regionsCollection = $this->getRegions($formattedParts);


        return $formattedParts->map(function (SharesReportPart $sharesReportPart, $key) use ($regionsCollection) {

            $advertising = $this->getAdvertising($sharesReportPart);

            $image = SVG::fromFile(self::MAP_SVG_TEMPLATE_PATH);
            $doc = $image->getDocument();

            $this->getHeader($doc, $sharesReportPart->getTitle());

            /** @var Regions $regions */
            $regions = app()->makeWith(Regions::class, ['document' => $doc]);
            $regionColorIterator = new ArrayIterator($this->getColorMap($regionsCollection, $sharesReportPart->getCode()));
            $regions->addRegions($regionColorIterator, $regionsCollection);

            $descriptionsColorIterator = new ArrayIterator(Handbook::CIRCLE_COLORS);
            $this->addDescription($doc, $descriptionsColorIterator, $advertising);

            $filePath = $this->diagramExporter->exportToPng($image, $this->getFileName($sharesReportPart->getTitle()));
            /** @var DiagramResponseBuilder $responseBuilder */
            /** @noinspection PhpUnhandledExceptionInspection */
            $responseBuilder = app()->make(DiagramResponseBuilder::class);
            return $responseBuilder
                ->setFilePath($filePath)
                ->setWidth($doc->getWidth())
                ->setHeight($doc->getHeight())
                ->build();
        });
    }

    private function addDescription(SVGDocumentFragment $document, ArrayIterator $colorIterator, Collection $advertising)
    {
        /** @var DescriptionBuilder $descriptionBuilder */
        /** @noinspection PhpUnhandledExceptionInspection */
        $descriptionBuilder = app()->make(DescriptionBuilder::class);
        $descriptionBuilder
            ->setTextOffsetX(686)
            ->setTextOffsetY(84)
            ->setValueOffsetX(877)
            ->setValueOffsetY(84)
            ->setCircleOffsetX(670)
            ->setCircleOffsetY(80)
            ->setCircleRadius(6)
            ->setOffsetYStep(28)
            ->setParts($advertising)
            ->setDocument($document)
            ->setMaxTextLength(15)
            ->setHorizontalLineHeight(1)
            ->setHorizontalLineWidth(318)
            ->setHorizontalLineColor('#E7E7E7')
            ->setTotalText('Итого');

        $description = $descriptionBuilder->build();
        $description->addDescriptions($colorIterator);
    }


    private function getRegions(Collection $parts)
    {
        return $parts->map(static function (SharesReportPart $sharesReportPart) {
            return new SimpleReportPart(
                $sharesReportPart->getTitle(),
                $sharesReportPart->getValue(),
                $sharesReportPart->getCode(),
                0
            );
        });
    }

    private function getAdvertising(SharesReportPart $parts)
    {
        $shares = $parts->getShares();
        return $shares->sortByDesc(static function (SimpleReportPart $simpleReportPart) {
            return (int)$simpleReportPart->getValue();
        });
    }

    private function getColorMap(Collection $regions, string $currentRegionCode)
    {
        $colors = $regions->map(static function (SimpleReportPart $reportPart) use ($currentRegionCode) {
            if ($reportPart->getCode() === $currentRegionCode) {
                return Handbook::VALUES_COLOR_ENABLE;
            }
            return Handbook::VALUES_COLOR_DISABLE;
        })->toArray();

        return $colors;
    }

    private function getHeader(SVGDocumentFragment $doc, string $title)
    {
        if (mb_strlen($title) > $this->maxTitleLength) {
            $title = mb_substr($title, 0, $this->maxTitleLength) . '...';
        }
        $doc->addChild($this->getTitleText($title, $this->titleOffsetX, $this->titleOffsetY));
    }
}
