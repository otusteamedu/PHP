<?php


namespace Models;


class Company {

    private string $name;

    public function __construct($f3, $name) {
        $this->f3 = $f3;
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}