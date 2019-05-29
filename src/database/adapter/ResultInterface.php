<?php

namespace crazydope\theater\database\adapter;

use Countable;
use Iterator;

interface ResultInterface extends Countable, Iterator
{

    public function isBuffered(): ?bool;

    public function isQueryResult(): bool;

    public function getAffectedRows(): int;

    public function getResource();

    public function getFieldCount(): int;
}