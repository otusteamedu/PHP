<?php

namespace crazydope\theater\Model;

interface ArrayDocumentInterface
{
    public function toArray(): array;

    public function exchangeArray(array $data);
}