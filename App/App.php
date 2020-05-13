<?php

class App {
    public function sum($a, $b) {
        return $a + $b;
    }

    public function run() {
        echo $this->sum(2, 3);
    }
}