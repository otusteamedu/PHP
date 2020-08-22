<?php

namespace Penguin\Controller;

use Penguin\Helpers\StringHelper;

class IndexController
{
    public function index() : void
    {
        include __DIR__ . '/../views/index.php';
    }

    public function post() : void
    {
        $postString = $_POST['string'] ?? '';

        $rightLength = strlen(StringHelper::onlyParenthesis($postString));

        if (!$postString ||
            $rightLength !== strlen($postString) ||
            $rightLength % 2 !== 0 ||
            !StringHelper::parenthesisValidator($postString)
        ) {
            http_response_code(400);
            echo 'String is invalid';
        } else {
            echo $postString;
        }
    }
}