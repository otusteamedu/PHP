<?php


namespace App\Utils\Transliterator;


interface TransliteratorInterface
{
    public function translit(string $subject): string;
}
