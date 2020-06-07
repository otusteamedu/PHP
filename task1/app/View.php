<?php


namespace App;


use App\Api\ViewInterface;
use Exception;

class View implements ViewInterface
{
    const VIEW_DIR = __DIR__.'/view/';

    private string $viewName;
    private array $parameters = [];

    public function __construct(string $viewName)
    {
        $this->viewName = $viewName;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function render(): string
    {
        $_viewPath = self::VIEW_DIR.$this->viewName.'.php';
        if (!is_file($_viewPath)) {
            throw new Exception('View is not found: '.$_viewPath);
        }
        ob_start();
        extract($this->parameters);
        require $_viewPath;
        return ob_get_clean();
    }

}