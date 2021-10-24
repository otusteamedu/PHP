<?php

namespace Resources\Views;


use App\Exceptions\ErrorCodes;
use App\Exceptions\Loader\ViewLoaderException;


class ViewsLoader
{
    /**
     * @var array
     */
    private array $data;


    /**
     * Конструктор класса
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Загружает View-файл
     *
     * @param string $view
     * @throws ViewLoaderException
     */
    public function load(string $view): void
    {
        extract($this->data);
        if (file_exists($view)) {
            include $view;
        } else {
            throw new ViewLoaderException("View '$view' doesn't found", ErrorCodes::getCode(ViewLoaderException::class));
        }
    }
}