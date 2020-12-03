<?php


namespace AYakovlev\Model;




interface iEventModel
{

    public function setName(string $name): string ;

    public function setPriority(int $priority): int;

    public function setConditions(array $conditions): array;

    public function addNoteToBD(): bool;

    public function resetAllDataFromBD();

}