<?php


namespace App\Services\Export\Diagrams;

use Illuminate\Support\Collection;
use SVG\Nodes\Structures\SVGDocumentFragment;

class DescriptionBuilder
{
    private $textOffsetX;
    private $textOffsetY;
    private $valueOffsetX;
    private $valueOffsetY;
    private $circleOffsetX;
    private $circleOffsetY;
    private $circleRadius;
    private $offsetYStep;

    private $maxTextLength;
    private $horizontalLineHeight;
    private $horizontalLineWidth;
    private $horizontalLineColor;
    private $totalText;

    /** @var Collection */
    private $parts;
    /** @var SVGDocumentFragment */
    private $document;

    private $errors;

    public function setTextOffsetX($textOffsetX)
    {
        $this->textOffsetX = $textOffsetX;
        return $this;
    }

    public function setTextOffsetY($textOffsetY)
    {
        $this->textOffsetY = $textOffsetY;
        return $this;
    }

    public function setValueOffsetX($valueOffsetX)
    {
        $this->valueOffsetX = $valueOffsetX;
        return $this;
    }

    public function setValueOffsetY($valueOffsetY)
    {
        $this->valueOffsetY = $valueOffsetY;
        return $this;
    }

    public function setCircleOffsetX($circleOffsetX)
    {
        $this->circleOffsetX = $circleOffsetX;
        return $this;
    }

    public function setCircleOffsetY($circleOffsetY)
    {
        $this->circleOffsetY = $circleOffsetY;
        return $this;
    }

    public function setCircleRadius($circleRadius)
    {
        $this->circleRadius = $circleRadius;
        return $this;
    }

    public function setOffsetYStep($offsetYStep)
    {
        $this->offsetYStep = $offsetYStep;
        return $this;
    }

    public function setParts(Collection $parts)
    {
        $this->parts = $parts;
        return $this;
    }

    public function setDocument(SVGDocumentFragment $document)
    {
        $this->document = $document;
        return $this;
    }

    public function setMaxTextLength($maxTextLength)
    {
        $this->maxTextLength = $maxTextLength;
        return $this;
    }

    public function setHorizontalLineHeight($horizontalLineHeight)
    {
        $this->horizontalLineHeight = $horizontalLineHeight;
        return $this;
    }

    public function setHorizontalLineWidth($horizontalLineWidth)
    {
        $this->horizontalLineWidth = $horizontalLineWidth;
        return $this;
    }

    public function setHorizontalLineColor($horizontalLineColor)
    {
        $this->horizontalLineColor = $horizontalLineColor;
        return $this;
    }

    public function setTotalText($totalText)
    {
        $this->totalText = $totalText;
        return $this;
    }

    public function build()
    {
        $this->validate();

        if (!empty($this->error)) {
            throw new \RuntimeException(implode(';', $this->error));
        }
        return Description::build($this);
    }

    public function validate()
    {
        if (empty($this->textOffsetX)) {
            $this->errors[] = 'Не задано смещение по оси X для текста';
        }

        if (empty($this->textOffsetY)) {
            $this->errors[] = 'Не задано смещение по оси Y для текста';
        }

        if (empty($this->valueOffsetX)) {
            $this->errors[] = 'Не задано смещение по оси X для значения';
        }

        if (empty($this->valueOffsetY)) {
            $this->errors[] = 'Не задано смещение по оси Y для значения';
        }

        if (empty($this->circleOffsetX)) {
            $this->errors[] = 'Не задано смещение по оси X для круга';
        }

        if (empty($this->circleOffsetY)) {
            $this->errors[] = 'Не задано смещение по оси Y для круга';
        }

        if (empty($this->circleRadius)) {
            $this->errors[] = 'Не задан радиус круга';
        }

        if (empty($this->offsetYStep)) {
            $this->errors[] = 'Не задан базовый шаг смещения по оси Y';
        }

        if (empty($this->parts)) {
            $this->errors[] = 'Не задана коллекция для построения описания графика';
        }

        if (!$this->parts instanceof Collection) {
            $this->errors[] = 'Части графика должны принадлежать классу ' . Collection::class;
        }

        if (empty($this->document)) {
            $this->errors[] = 'Не передан документ, к которому добавляется описание';
        }

        if (!$this->document instanceof SVGDocumentFragment) {
            $this->errors[] = 'Документ должн принадлежать классу ' . SVGDocumentFragment::class;
        }

        if (empty($this->maxTextLength)) {
            $this->errors[] = 'Не задана максимальная длина текста';
        }

        if (empty($this->horizontalLineHeight)) {
            $this->errors[] = 'Не задана высота горизонтальной линии';
        }

        if (empty($this->horizontalLineWidth)) {
            $this->errors[] = 'Не задана ширина горизонтальной линии';
        }

        if (empty($this->horizontalLineColor)) {
            $this->errors[] = 'Не задан цвет горизонтальной линии';
        }

        if (empty($this->totalText)) {
            $this->errors[] = 'Не задан итоговый текст';
        }
    }

    public function getTextOffsetX()
    {
        return $this->textOffsetX;
    }

    public function getTextOffsetY()
    {
        return $this->textOffsetY;
    }

    public function getValueOffsetX()
    {
        return $this->valueOffsetX;
    }

    public function getValueOffsetY()
    {
        return $this->valueOffsetY;
    }

    public function getCircleOffsetX()
    {
        return $this->circleOffsetX;
    }

    public function getCircleOffsetY()
    {
        return $this->circleOffsetY;
    }

    public function getCircleRadius()
    {
        return $this->circleRadius;
    }

    public function getOffsetYStep()
    {
        return $this->offsetYStep;
    }

    public function getMaxTextLength()
    {
        return $this->maxTextLength;
    }

    public function getHorizontalLineHeight()
    {
        return $this->horizontalLineHeight;
    }

    public function getHorizontalLineWidth()
    {
        return $this->horizontalLineWidth;
    }

    public function getHorizontalLineColor()
    {
        return $this->horizontalLineColor;
    }

    public function getTotalText()
    {
        return $this->totalText;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function getDocument()
    {
        return $this->document;
    }
}
