<?php

require("vendor/autoload.php");

use PHPUnit\Framework\TestCase;

class AppTest extends TestCase{
    public function testSum() {
        $app = new \App();
        $this->assertEquals(2 + 3, $app->sum(2, 3));
    }
}