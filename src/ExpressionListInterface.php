<?php

namespace crazydope\calculator;

interface ExpressionListInterface
{
    public function add( ExpressionInterface $expression);
    public function remove(int $idx);
    public function get(int $idx): ExpressionInterface;
    public function findA(int $idx): ?int;
    public function findB(int $idx): ?int;
}