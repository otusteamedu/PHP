<?php


namespace Otushw\Visitor;

/**
 * Interface Entity
 *
 * @package Otushw\Visitor
 */
interface Entity
{
    /**
     * @param Visitor $visitor
     */
    public function accept(Visitor $visitor): void;
}