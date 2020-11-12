<?php declare(strict_types=1);


namespace Otus;


/**
 * Class Brackets
 * Класс проверки валидности открытых и закртых скобок
 * @package Brackets
 */
class Brackets
{
    private string $string;
    private array $errors;


    /**
     * Функция валидации строки со скобками
     * @param string $string
     * @return bool
     */
    public function check(string $string): bool
    {
        $this->string = trim($string);
        return $this->validation() && $this->isNotEmpty();
    }


    private function addError(string $msg): void
    {
        $this->errors[] = $msg;
    }


    private function validation(): bool
    {
        if ((strlen($this->string) % 2) != 0) {
            $this->addError("Не корректное количество открытых и закрытых скобок");
            return false;
        }

        $i = 0;
        foreach (str_split($this->string) as $char) {
            if ($char == "(")
                $i++;
            if ($char == ")")
                $i--;
            if ($i < 0) {
                $this->addError("Не корретная строка, открывающая скобка после закрывающей");
                return false;
            }
        }
        if ($i == 0) {
            return true;
        } else {
            $this->addError("Не корретная строка");
            return false;
        }

    }


    private function isNotEmpty(): bool
    {
        if (empty($this->string)) {
            $this->addError("Пустая строка");
            return false;
        } else {
            return true;
        }
    }

    /**
     * Метод возвращает ошибки валидации
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}