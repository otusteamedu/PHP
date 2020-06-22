<?php

namespace Contracts;

interface EmailCheckerInterface 
{
    public function checkEmail(): bool;
    public function checkEmailsFromFile(): bool;
    public function checkEmailsArray(): bool;
}