<?php


namespace Otushw\Visitor;

interface Entity
{
    public function accept(Visitor $visitor): void;
}