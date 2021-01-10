<?php

namespace App;

class App
{
    private ?string $query;

    public function __construct()
    {
        $this->query = isset($_POST['query']) ?? null;
    }

    public function run(): void
    {
        if (empty(trim($this->query))) {
            http_response_code(400);

            return;
        }

        http_response_code(200);
    }
}