<?php

namespace App;

use Repetitor202\FileParser;
use Repetitor202\Email\Report as EmailReport;


class App
{
    public function run(): void
    {
        $emails = (new FileParser())->getLines($_SERVER['argv'][1]);
        (new EmailReport())->validateList($emails);
    }
}