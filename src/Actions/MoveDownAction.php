<?php


namespace Src\Actions;


use Src\Entities\Play;

class MoveDownAction extends BasePlayAction
{
    public function apply(Play $play): void
    {
        $element = $play->getCurrentElement();

        if($element->getPlacementRow() > 0){
            //сдвигаем вниз на 1 клетку
            $element->setPlacementRow($element->getPlacementRow() - 1);
        }

        $play->setCurrentElement($element);

        parent::apply($play);
    }
}