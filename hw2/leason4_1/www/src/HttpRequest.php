<?php

/**
 * Class HttpRequest
 * Класс обработки запроса на сервер
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */
class HttpRequest
{
    private $getData  = [];
    private $postData = [];


    public function __construct()
    {
        $this->getData  = $_GET;
        $this->postData = $_POST;
    }


    /**
     * @return bool
     */
    public function isGet()
    {
        return ! empty($this->getData);
    }


    /**
     * @return bool
     */
    public function isPost()
    {
        return ! empty($this->postData);
    }


    /**
     * Получить параметр запроса
     *
     * @param string $paramName    название параметра
     * @param mixed  $defaultValue значение по умолчанию
     *
     * @return mixed|null
     */
    public function getParam($paramName, $defaultValue = null)
    {
        if ($this->isGet()) {
            return ( ! empty($this->getData[$paramName])) ? $this->getData[$paramName] : $defaultValue;
        } elseif ($this->isPost()) {
            return ( ! empty($this->postData[$paramName])) ? $this->postData[$paramName] : $defaultValue;
        }
    }
}