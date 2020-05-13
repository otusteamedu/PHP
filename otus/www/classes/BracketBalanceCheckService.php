<?php

namespace Classes;

interface BracketBalanceCheckService
{
    public function run(): BracketCheckResponse;
}
