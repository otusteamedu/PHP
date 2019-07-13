<?php

namespace crazydope\youtube;

interface ArrayDocumentInterface
{
    public function toArray(): array;

    public function exchangeArray(array $data);
}