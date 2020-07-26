<?php


namespace App\Services\Export\Diagrams;


use SVG\Nodes\Shapes\SVGCircle;
use SVG\Nodes\Texts\SVGText;

trait DiagramSvgElementsGetterTrait
{
    protected function getDescriptionCircle($cx, $cy, $radius, $color)
    {
        $circle = new SVGCircle($cx, $cy, $radius);
        $circle->setAttribute('fill', $color);

        return $circle;
    }

    protected function getBoldText($value, $x, $y)
    {
        $text = new SVGText($value, $x, $y);
        $text->setAttribute('fill', 'black');
        $text->setAttribute('xml:space', 'preserve');
        $text->setAttribute('font-family', 'Arial');
        $text->setAttribute('font-size', '13');
        $text->setAttribute('font-weight', 'bold');
        $text->setAttribute('letter-spacing', '0px');
        $text->setStyle('white-space', 'pre');

        return $text;
    }

    protected function getSimpleText($value, $x, $y)
    {
        $text = new SVGText($value, $x, $y);
        $text->setAttribute('fill', 'black');
        $text->setAttribute('xml:space', 'preserve');
        $text->setAttribute('font-family', 'Arial');
        $text->setAttribute('font-size', '13');
        $text->setAttribute('letter-spacing', '0px');
        $text->setStyle('white-space', 'pre');

        return $text;
    }

    protected function getTitleText($value, $x, $y)
    {
        $text = new SVGText($value, $x, $y);
        $text->setAttribute('fill', 'black');
        $text->setAttribute('xml:space', 'preserve');
        $text->setAttribute('font-family', 'Arial');
        $text->setAttribute('font-family', 'Arial');
        $text->setAttribute('font-size', '19');
        $text->setAttribute('font-weight', 'bold');
        $text->setAttribute('letter-spacing', '0px');
        $text->setStyle('white-space', 'pre');

        return $text;
    }
}
