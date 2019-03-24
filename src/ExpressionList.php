<?php

namespace crazydope\calculator;

use crazydope\calculator\Exceptions\ExpressionNotFoundException;
use crazydope\calculator\Exceptions\NotExpression;

class ExpressionList
    implements \Iterator, \Countable, ExpressionListInterface
{
    use ExpressionListIteratorTrait;
    protected $list = [];

    public function add( ExpressionInterface $expression ): void
    {
        $this->list[] = $expression;
    }

    public function remove( int $idx ): void
    {
        unset($this->list[$idx]);
    }

    /**
     * @param int $idx
     * @return ExpressionInterface
     * @throws ExpressionNotFoundException
     */
    public function get( int $idx ): ExpressionInterface
    {
        if ( !isset($this->list[$idx]) ) {
            throw new ExpressionNotFoundException('Выражение не найдено!');
        }

        return $this->list[$idx];
    }

    /**
     * @param int $idx
     * @return int|null
     * @throws NotExpression
     */
    public function findA( int $idx ): ?int
    {
        foreach ( $this->list as $key => $item ) {
            if ( !$item instanceof ExpressionInterface ) {
                throw new NotExpression($key . ' не  явдяется Expression');
            }
            if ( $item->getAIdx() === $idx ) {
                return $key;
            }
        }
        return null;
    }

    /**
     * @param int $idx
     * @return int|null
     * @throws NotExpression
     */
    public function findB( int $idx ): ?int
    {
        foreach ( $this->list as $key => $item ) {
            if ( !$item instanceof ExpressionInterface ) {
                throw new NotExpression($key . ' не  явдяется Expression');
            }
            if ( $item->getBIdx() === $idx ) {
                return $key;
            }
        }
        return null;
    }

    public function count(): int
    {
        return count($this->list);
    }
}