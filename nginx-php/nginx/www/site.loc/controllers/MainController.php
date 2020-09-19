<?php

/**
 * Class MainController
 */
class MainController
{
    /** @var int Минимальная длина строки */
    protected int $minLength = 10;
    protected string $response = '';

    public function checkString(): string
    {
        $string = htmlspecialchars($_POST['string']);
        $countSymbols = mb_strlen($string);

        if (($countSymbols % 2) !== 0) {
            http_response_code(400);
            return 'Everything is bad!';
        }

        if (mb_substr($string, 0, 1) === ')' || mb_substr($string, $countSymbols - 1, 1) === '(') {
            http_response_code(400);
            return 'Everything is bad!';
        }

        $countSymbol1 = mb_substr_count($string, '(');
        if (($countSymbols - $countSymbol1) === $countSymbol1) {
            http_response_code(200);
            return 'Everything is ok!';
        } else {
            http_response_code(400);
            return 'Everything is bad!';
        }
    }

    /**
     * @return int
     */
    public function getMinLength(): int
    {
        return $this->minLength;
    }

    /**
     * @param int $minLength
     */
    public function setMinLength(int $minLength): void
    {
        $this->minLength = $minLength;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }
}

$mainController = new MainController();

if (!empty($_POST['string'])) {
    $mainController->setResponse($mainController->checkString());
}