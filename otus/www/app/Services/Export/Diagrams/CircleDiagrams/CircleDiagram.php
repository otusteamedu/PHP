<?php


namespace App\Services\Export\Diagrams\CircleDiagrams;


use App\Services\AdvCampaigns\ActivityStatistic\PartsReport;
use App\Services\Export\Diagrams\BaseDiagram;
use App\Services\Export\Diagrams\DescriptionBuilder;
use App\Services\Export\Diagrams\DiagramExporter;
use App\Services\Export\Diagrams\DiagramResponseBuilder;
use App\Services\Export\Diagrams\DiagramSvgElementsGetterTrait;
use App\Services\Export\Diagrams\MapDiagrams\Handbook;
use App\Services\Export\Diagrams\ReportDiagrams;
use ArrayIterator;
use SVG\Nodes\Structures\SVGDocumentFragment;
use SVG\SVG;

class CircleDiagram extends BaseDiagram implements ReportDiagrams
{
    use DiagramSvgElementsGetterTrait;

    private const CIRCLE_SVG_TEMPLATE_PATH = __DIR__ . '/pie-chart.svg';

    private $backgroundCircleRadiusX = 4;

    private $maxTitleLength = 22;
    private $titleFirstLineOffsetY = 42;
    private $titleOffsetStepY = 24;
    private $titleOffsetX = 38;

    private $maxDescriptionTitleLength = 31;


    private $partsReport;
    private $diagramExporter;

    public function __construct(PartsReport $partsReport, DiagramExporter $diagramExporter)
    {
        $this->partsReport = $partsReport;
        $this->diagramExporter = $diagramExporter;
    }

    public function getReportDiagram()
    {
        $image = SVG::fromFile(self::CIRCLE_SVG_TEMPLATE_PATH);
        $doc = $image->getDocument();
        $colorCircleIterator = new ArrayIterator(Handbook::CIRCLE_COLORS);
        $colorDescriptionIterator = new ArrayIterator(Handbook::CIRCLE_COLORS);

        $this->addTitles($doc);

        /** @var Circle $circle */
        $circle = app()->makeWith(Circle::class, ['parts' => $this->partsReport->getParts(), 'document' => $doc]);
        $circle->addCircleDiagram($colorCircleIterator);

        $this->addDescription($doc, $colorDescriptionIterator);

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

    private function addTitles(SVGDocumentFragment $doc)
    {
        $titles = $this->getTitles();

        if (isset($titles[0])) {
            $firstLine = $this->getTitleText($titles[0], $this->titleOffsetX, $this->titleFirstLineOffsetY);
            $doc->addChild($firstLine);
        }

        if (isset($titles[1])) {
            $secondLine = $this->getTitleText($titles[1], $this->titleOffsetX, $this->titleFirstLineOffsetY + $this->titleOffsetStepY);
            $doc->addChild($secondLine);
        }
    }

    private function addDescription(SVGDocumentFragment $document, ArrayIterator $colorIterator)
    {
        /** @var DescriptionBuilder $descriptionBuilder */
        /** @noinspection PhpUnhandledExceptionInspection */
        $descriptionBuilder = app()->make(DescriptionBuilder::class);
        $descriptionBuilder
            ->setTextOffsetX(51)
            ->setTextOffsetY(376)
            ->setValueOffsetX(377)
            ->setValueOffsetY(376)
            ->setCircleOffsetX(38)
            ->setCircleOffsetY(372)
            ->setCircleRadius(6)
            ->setOffsetYStep(28)
            ->setParts($this->partsReport->getParts())
            ->setDocument($document)
            ->setMaxTextLength(31)
            ->setHorizontalLineHeight(1)
            ->setHorizontalLineWidth(483)
            ->setHorizontalLineColor('#E7E7E7')
            ->setTotalText('Итого');

        $description = $descriptionBuilder->build();
        $description->addDescriptions($colorIterator);
    }

    private function getTitles()
    {
        $title = $this->partsReport->getTitle();

        if (mb_strlen($title) <= $this->maxTitleLength) {
            return $title;
        }

        $titleParts = explode(' ', $title);
        $partsCount = count($titleParts);

        $result = [];
        $resultString = '';

        foreach ($titleParts as $key => $part) {

            if (mb_strlen($part) >= $this->maxTitleLength) {
                $result[] = $part;
                continue;
            }

            $string = trim($resultString . $part);

            if (mb_strlen($string) >= $this->maxTitleLength) {
                $result[] = !empty($resultString) ? $resultString : $part;
                $resultString = '';
                if ($key + 1 === $partsCount) {
                    $result[] = !empty($resultString) ? $resultString : $part;
                }
                continue;
            }

            $resultString .= $part . ' ';

            if ($key + 1 === $partsCount) {
                $result[] = $resultString;
            }
        }

        return $result;
    }
}
