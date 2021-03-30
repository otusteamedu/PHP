<?php


namespace App\Services\Orm\Interfaces;


interface ModelBuilderInterface
{
    public function build(array $raw): OrmModelInterface;
}
