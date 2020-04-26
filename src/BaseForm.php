<?php

namespace Bjlag;

use League\Route\Http\Exception\UnprocessableEntityException;

abstract class BaseForm
{
    /** @var array */
    protected $data;

    /**
     * Получить поля формы.
     *
     * @return array
     */
    abstract protected function getFields(): array;

    /**
     * @return $this
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function fillAndValidate(): self
    {
        foreach ($this->getFields() as $field) {
            if (!isset($this->data[$field])) {
                throw new UnprocessableEntityException("Поле '{$field}' обязательно для заполнения.");
            }

            $setterName = strtr($field, ['_' => ' ']);
            $setterName = ucwords($setterName);
            $setterName = 'set' . strtr($setterName, [' ' => '']);

            $this->{$setterName}($this->data[$field]);
        }

        return $this;
    }
}
