<?php

namespace Classes\Email;

interface EmailCheckService
{
    public function run(): EmailCheckResponse;
}
