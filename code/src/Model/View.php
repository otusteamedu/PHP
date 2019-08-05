<?php

namespace crazydope\theater\Model;

class View
{
    private $data = [];

    private $render = false;

    public function __construct(string $template)
    {
        $file = '../src/View/' . strtolower($template) . '.php';

        if (file_exists($file)) {
            $this->render = $file;
        } else {
            throw new TemplateNotFoundException('Template ' . $template . ' not found!');
        }
    }

    public function assign($variable, $value): void
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        extract($this->data, EXTR_OVERWRITE);
        include $this->render;
    }
}