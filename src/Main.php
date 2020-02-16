<?php

namespace App;

class Main
{
    public function run(): void
    {
        $this->phpInfo();
    }

    private function phpInfo(): void
    {
        phpinfo();
    }
}
