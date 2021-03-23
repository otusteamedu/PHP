<?php

namespace ValidBrackets\Core;

class View
{
    public static function render(string $view, array $data = []): void{
        $viewPath = __DIR__ . "/../View/" . $view . ".tpl.php";

        if(file_exists($viewPath)){
            include $viewPath;
        }
    }
}
