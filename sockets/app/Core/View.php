<?php


namespace App\Core;


use App\Api\ViewInterface;
use Exception;

class View implements ViewInterface
{
    const VIEW_DIR = __DIR__ . '/../theme/view/';
    const LAYOUT_DIR = __DIR__ . '/../theme/layout/';

    private string $viewName;
    private array $parameters = [];
    private string $layout = 'main';

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
    protected function renderView(): string
    {
        $_viewPath = self::VIEW_DIR . $this->viewName . '.php';
        if (!is_file($_viewPath)) {
            throw new Exception('View is not found: ' . $_viewPath);
        }
        ob_start();
        extract($this->parameters);
        require $_viewPath;
        return ob_get_clean();
    }

    public function render(): string
    {
        $_layoutPath = self::LAYOUT_DIR . $this->layout . '.php';
        if (!is_file($_layoutPath)) {
            throw new Exception('Layout is not found: ' . $_layoutPath);
        }
        $content = $this->renderView();
        ob_start();
        require $_layoutPath;
        return ob_get_clean();
    }

    public function setLayout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }
}