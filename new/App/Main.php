<?php

class Main {
    public function index($f3) {
        $name = $f3->get("name");

        $company = new Models\Company($f3, $name);

        echo "Name of company is ".$company->getName();
    }
}