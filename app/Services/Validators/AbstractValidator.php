<?php

namespace app\Services\Validators;

use app\Exceptions\Email\BadEmailException;

abstract class AbstractValidator
{
    public const VALIDATOR_NAME = 'Default';
    public const ITEM_NAME      = 'Default';

    protected array $itemsList;

    /**
     * Возвращает название Валидатора, используя позднее статическое связывание
     * т.е. у каждого класса будет возвращено значение VALIDATOR_NAME переопределенное в классе
     *
     * @return string
     */
    protected function getValidatorName(): string
    {
        return static::VALIDATOR_NAME;
    }

    /**
     * Возвращает название элемента, используя позднее статическое связывание
     * т.е. у каждого класса будет возвращено значение ITEM_NAME переопределенное в классе
     *
     * @return string
     */
    protected function getItemName(): string
    {
        return static::ITEM_NAME;
    }

    /**
     * Валидирует список элементов.
     * Название элемента, в качестве ключа массива, берется из константы `private const ITEM_NAME`.
     * В дочерних классах обязательно необходима реализация метода isValidItem(string $item): bool;
     *
     * @return array
     */
    public function validate(): array
    {
        $result = [];
        foreach ($this->getItemsList() as $validatingItem) {
            $result[] = ($this->isValidItem($validatingItem))
                ? [$this->getItemName() => $validatingItem, "valid" => true]
                : [$this->getItemName() => $validatingItem, "valid" => false];
        }
        return $result;
    }

    /**
     * Возвращает набор элементов подготовленных для валидации.
     * Переопределяется в дочерних классах, чтобы подставить, требуемый дочернему классу, список для проверки.
     *
     * @return array
     */
    protected function getItemsList(): array
    {
        return $this->itemsList;
    }

    /**
     * Устанавливает массив элементов для проверки.
     * @param array $data
     */
    abstract public function setDataToValidate(array $data): void;

    /**
     * Возвращает true если элемент удовлетворяет условиям валидации.
     *
     * @param string $item
     * @return bool
     */
    abstract protected function isValidItem(string $item): bool;

    /**
     * Возвращает структурированные данные верифицируемых элементов.
     * Используется исключительно в демонстрационных целях работы валидатора
     *
     * @return array
     */
    public function getFormatEmailList(): array {}

}