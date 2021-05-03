<?php

namespace Src\Actions;

use Src\Entities\Play;

interface Action
{
    public function apply(Play $play) : void;
}