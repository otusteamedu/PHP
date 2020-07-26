<?php


namespace App\Services\Export\Diagrams;


use App\Services\AdvCampaigns\ActivityStatistic\SimpleReportPart;
use Illuminate\Support\Collection;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Structures\SVGDocumentFragment;

/**
 * @property integer $textOffsetX
 * @property integer $textOffsetY
 * @property integer $valueOffsetX
 * @property integer $valueOffsetY
 * @property integer $circleOffsetX
 * @property integer $circleOffsetY
 * @property integer $circleRadius
 * @property integer $offsetYStep
 * @property integer $maxTextLength
 * @property integer $horizontalLineHeight
 * @property integer $horizontalLineWidth
 * @property integer $horizontalLineColor
 * @property integer $totalText
 * @property Collection $parts
 * @property SVGDocumentFragment $document
 * Class Descriptions
 * @package App\Services\Export\Diagrams\MapDiagrams
 */
class Description extends BaseDiagram
{
    use DiagramSvgElementsGetterTrait;

    private $textOffsetX;
    private $textOffsetY;
    private $valueOffsetX;
    private $valueOffsetY;
    private $circleOffsetX;
    private $circleOffsetY;
    private $circleRadius;
    private $offsetYStep;

    private $parts;
    private $document;

    private $maxTextLength;
    private $horizontalLineHeight;
    private $horizontalLineWidth;
    private $horizontalLineColor;
    private $totalText;

    public static function build(DescriptionBuilder $builder)
    {
        $self = new self();
        $self->textOffsetX = $builder->getTextOffsetX();
        $self->textOffsetY = $builder->getTextOffsetY();
        $self->valueOffsetX = $builder->getValueOffsetX();
        $self->valueOffsetY = $builder->getValueOffsetY();
        $self->circleOffsetX = $builder->getCircleOffsetX();
        $self->circleOffsetY = $builder->getCircleOffsetY();
        $self->circleRadius = $builder->getCircleRadius();
        $self->offsetYStep = $builder->getOffsetYStep();
        $self->parts = $builder->getParts();
        $self->document = $builder->getDocument();
        $self->maxTextLength = $builder->getMaxTextLength();
        $self->horizontalLineHeight = $builder->getHorizontalLineHeight();
        $self->horizontalLineWidth = $builder->getHorizontalLineWidth();
        $self->horizontalLineColor = $builder->getHorizontalLineColor();
        $self->totalText = $builder->getTotalText();

        return $self;
    }

    public function addDescriptions(\ArrayIterator $colorIterator)
    {
        $this->addBrandsValuesList($colorIterator);
        $this->addHorizontalLine();
        $this->addTotal();
    }

    private function addBrandsValuesList(\ArrayIterator $colorIterator)
    {
        $this->parts->each(function (SimpleReportPart $part) use ($colorIterator) {
            $brand = $this->getBoldText($this->getDescriptionTitle($part->getTitle()), $this->textOffsetX, $this->textOffsetY);
            $value = $this->getSimpleText(number_format($part->getValue(), 0, '', ' '), $this->valueOffsetX, $this->valueOffsetY);
            $circle = $this->getDescriptionCircle($this->circleOffsetX, $this->circleOffsetY, $this->circleRadius, $this->getColor($colorIterator));

            $this->document->addChild($brand);
            $this->document->addChild($value);
            $this->document->addChild($circle);

            $this->textOffsetY += $this->offsetYStep;
            $this->valueOffsetY += $this->offsetYStep;
            $this->circleOffsetY += $this->offsetYStep;

        });
    }

    private function getDescriptionTitle(string $title)
    {
        if (mb_strlen($title) > $this->maxTextLength) {
            $title = mb_substr($title, 0, $this->maxTextLength) . '...';
        }
        return $title;
    }

    private function addTotal()
    {
        $offsetY = $this->textOffsetY + $this->offsetYStep;
        $totalText = $this->getBoldText($this->totalText, $this->textOffsetX, $offsetY);
        $totalSum = $this->getBoldText(number_format($this->getTotalSum(), 0, '', ' '), $this->valueOffsetX, $offsetY);
        $this->document->addChild($totalText);
        $this->document->addChild($totalSum);
    }

    private function getTotalSum()
    {
        $test = 1;
        return $this->parts->sum(static function (SimpleReportPart $simpleReportPart) {
            return $simpleReportPart->getValue();
        });
    }

    private function addHorizontalLine()
    {
        $rect = new SVGRect(null, null, $this->horizontalLineWidth, $this->horizontalLineHeight);
        $transformData = sprintf('0.83 0 0 -1 %s %s ', $this->circleOffsetX - 10, $this->textOffsetY);
        $transform = sprintf('matrix(%s)', $transformData);
        $rect->setAttribute('transform', $transform);
        $rect->setAttribute('fill', $this->horizontalLineColor);
        $this->document->addChild($rect);
    }
}
