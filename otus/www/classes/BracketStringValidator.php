<?php

namespace Classes;

interface BracketStringValidator
{
    public function isValid(): bool;
    public function getErrors();
}
