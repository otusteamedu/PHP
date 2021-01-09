<?php


namespace Otushw\DBSystem;


abstract class DocumentDTO
{
    abstract public function getDocumentStruct(): array;

    abstract public function getDocumentName(): string;
}