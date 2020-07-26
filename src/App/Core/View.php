<?php

namespace Ozycast\App\core;

class View
{
    // папка с файлами вида
    const FOLDER = "App/Views/";

    // Шаблон по умолчанию
    public $layout = 'layouts/main.php';

    /**
     * Загружаем представление
     * @param string $content
     * @param array $data
     */
    public function generate(string $content, $data = [])
    {
        $content .= ".php";
        extract($data, EXTR_PREFIX_SAME, 'var');
        $view = self::FOLDER . $this->layout;
        include $view;
    }

}