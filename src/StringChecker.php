<?php


class StringChecker
{
    public function check(array $request): string
    {
        if (!isset($request['string'])) {
            throw new Exception('Строка не передана', 400);
        }
        if (strlen($request['string']) === 0) {
            throw new Exception('Передана пустая строка', 400);
        }
        if (!$this->checkBrackets($request['string'])) {
            throw new Exception('Скобки расставлены неправильно', 404);
        }

        return 'Строка корректна';
    }

    private function checkBrackets(string $str): bool
    {
        $count = 0;
        foreach (str_split($str) as $item) {
            switch ($item) {
                case '(':
                    $count++;
                    break;
                case ')':
                    $count--;
                    break;
                default:
                    throw new Exception('В строке не только скобки', 404);
            }
            if ($count < 0) {
                return false;
            }
        }
        if ($count > 0) {
            return false;
        }
        return true;
    }
}