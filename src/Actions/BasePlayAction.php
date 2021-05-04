<?php


namespace Src\Actions;


use Src\Entities\Play;

class BasePlayAction implements Action
{
    private Action $action;

    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    public function apply(Play $play): void
    {
        $this->action->apply($play);
    }
}