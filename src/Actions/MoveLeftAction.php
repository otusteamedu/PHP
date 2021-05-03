<?php


namespace Src\Actions;


use Src\Entities\Play;


class MoveLeftAction extends BasePlayAction
{
    public function apply(Play $play): void
    {
        $element = $play->getCurrentElement();

        if($element->getPlacementCol() > 0){
            //сдвигаем влево на 1 клетку
            $element->setPlacementCol($element->getPlacementCol() - 1);
        }

        $play->setCurrentElement($element);

        parent::apply($play);
    }
}