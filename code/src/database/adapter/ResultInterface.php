<?php

namespace crazydope\theater\database\adapter;

interface ResultInterface
{
    public function isBuffered(): ?bool;

    public function isQueryResult(): bool;

    public function getAffectedRows(): int;

    public function getResource();

    public function getFieldCount(): int;
}