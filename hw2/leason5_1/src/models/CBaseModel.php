<?php

namespace models;
/**
 * Class CBaseModel
 *
 * @package models
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
class CBaseModel implements IModel
{
    private $errors;
    private $_validators;


    /**
     * Очистить ошибки
     */
    public function clearError()
    {
        $this->errors = [];
    }


    /**
     * Получить ошибки
     *
     * @return mixed
     */
    public function getLastError()
    {
        return $this->errors;
    }


    /**
     * Добавить сообщение об ошибке
     *
     * @param string $attr аттрибут модели
     * @param string $msg  сообщение
     */
    public function addError($attr, $msg)
    {
        $this->errors[$attr] = $msg;
    }


    /**
     * Есть ли ошибки валидации
     *
     * @return bool
     */
    public function hasError()
    {
        return ! empty($this->errors);
    }


    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }


    /**
     * Валидация атрибута
     *
     * @param string      $attr  название аттрибута
     * @param string|null $value значение аттрибута
     *
     * @return bool|void
     */
    public function validate($attr, $value = null)
    {
        if (empty($value)) {
            $value = $this->{$attr};
        }
        if (empty($this->_validators)) {
            $this->createValidatorList();
            if (empty($this->_validators)) {
                $this->addError($attr, 'No validators available');
                return false;
            }
        }
        $rules = $this->rules();
        foreach ($rules as $rule) {
            if ($rule[0] == $attr) {
                $validatorClass = $rule[1];
                if (!in_array($validatorClass, $this->_validators)) {
                    $this->addError($attr, sprintf('Unknown validator %s', $validatorClass));
                    return false;
                }
                if (count($rule) > 1) {
                    $params = array_slice($rule, 2);
                } else {
                    $params = [];
                }
                $validatorClass = 'validator\\'.$validatorClass;
                $validator = new $validatorClass($params);
                if ( ! $validator->validate($value)) {
                    $this->addError($attr, $validator->getLastError());
                    return false;
                } else {
                    return true;
                }
            }
        }
    }


    /**
     * Создать список используемых валидаторов
     */
    private function createValidatorList()
    {
        $rules = $this->rules();
        foreach ($rules as $rule) {
            // $rule[0] - attr name
            // $rule[1] - validator class
            // $rule[2..] - validator params
            if ( ! empty($rule[1])) {
                $validatorClassName = $rule[1];
                if (class_exists('validator\\'.$validatorClassName, true)) {
                    $this->_validators[] = $validatorClassName;
                } else {
                    echo "Class $validatorClassName not found \n";
                }
            }
        }
    }
}