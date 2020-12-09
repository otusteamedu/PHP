<?php


namespace AYakovlev\Core;


class View
{
    public static function render(string $view, array $data = [], int $code = 200): void
    {
        http_response_code($code);
        $viewPath = __DIR__ . "/../View/" . $view . ".tpl.php";

        if (file_exists($viewPath)) {

            ob_start();
            include $viewPath;
            $buffer = ob_get_contents();
            ob_end_clean();

            echo $buffer;
        }
    }
}