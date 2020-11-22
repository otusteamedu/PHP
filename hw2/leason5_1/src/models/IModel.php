<?php

namespace models;
/**
 * Interface IModel
 *
 * @package models
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
interface IModel
{
    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules();


    /**
     * Валидировать значение
     *
     * @param string $attr  Название аттрибута
     * @param string $value Значение аттрибута
     *
     * @return bool
     */
    public function validate($attr, $value = null);


    public function addError($attr, $msg);


    /**
     * Последняя ошибка
     *
     * @return mixed
     */
    public function getLastError();


    /**
     * Очистить ошибки
     */
    public function clearError();


    /**
     * Есть ли ошибки
     *
     * @return bool
     */
    public function hasError();
}