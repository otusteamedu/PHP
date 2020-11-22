<?php

namespace validator;

class CBaseValidator implements IValidator
{
    private $error;


    /**
     * CBaseValidator constructor.
     *
     * @param mixed ...$params
     */
    public function __construct(...$params)
    {
        // Установка параметров
        foreach ($params as $param) {
            foreach ($param as $k => $v) {
                if (property_exists($this, $k)) {
                    $this->{$k} = $v;
                }
            }
        }
    }


    /**
     * @param $value
     */
    public function validate($value)
    {
        // TODO: Implement validate() method.
    }


    /**
     * Установить сообщение с ошибкой
     *
     * @param string $msg
     */
    public function setError($msg)
    {
        $this->error = $msg;
    }


    /**
     * Получить сообщение об ошибке
     *
     * @return string
     */
    public function getLastError()
    {
        return $this->error;
    }


    /**
     * Очистить ошибки
     */
    public function clearError()
    {
        $this->error = '';
    }


    /**
     * Есть ли ошибки
     *
     * @return bool
     */
    public function hasError()
    {
        return ! empty($this->error);
    }
}