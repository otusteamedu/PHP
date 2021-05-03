<?php


namespace Src\Actions;


use Src\Entities\Play;

class RotateAction extends BasePlayAction
{
    public function apply(Play $play): void
    {
        $element = $play->getCurrentElement();

        $element->rotate();

        $play->setCurrentElement($element);

        parent::apply($play);
    }
}