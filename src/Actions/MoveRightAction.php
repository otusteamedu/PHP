<?php


namespace Src\Actions;


use Src\Entities\Play;


class MoveRightAction extends BasePlayAction
{
    public function apply(Play $play): void
    {
        $element = $play->getCurrentElement();

        if($element->getPlacementCol() < $play->getPlayGround()->getCols()){
            //сдвигаем вправо на 1 клетку
            $element->setPlacementCol($element->getPlacementCol() + 1);
        }

        $play->setCurrentElement($element);

        parent::apply($play);
    }
}