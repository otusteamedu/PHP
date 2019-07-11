<?php
declare(strict_types=1);


class RequestsProcessor
{
    public function getRequestMethod(array $server): string
    {
        return $server['REQUEST_METHOD'];
    }

    public function isCorrectParameter(string $key, string $value, array $server): bool
    {
        if ($key === 'string') {
            if (strlen("$key=$value") == $server['CONTENT_LENGTH'] && $this->isCorrectBrackets($value)) {
                return true;
            }
        }
        return false;
    }

    private function isCorrectBrackets(string $string): bool
    {
        $stringLength = strlen($string);
        $stack = [];
        for ($i = 0; $i < $stringLength; $i++) {
            $symbol = $string[$i];
            if ($symbol == '(') {
                $stack[] = $symbol;
            } elseif ($symbol == ')') {
                if (!$lastStackSymbol = array_pop($stack)) {
                    return false;
                }
                if ($symbol == ')' && $lastStackSymbol != '(') {
                    return false;
                }
            }
        }
        return count($stack) === 0;
    }
}