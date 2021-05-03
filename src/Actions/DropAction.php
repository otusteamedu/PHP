<?php


namespace Src\Actions;


use Src\Entities\Play;

class DropAction extends BasePlayAction
{
    private const DROP_SPEED = 10;

    public function apply(Play $play): void
    {
        $element = $play->getCurrentElement();

        $element->setSpeed(self::DROP_SPEED);

        $play->setCurrentElement($element);

        parent::apply($play);
    }
}