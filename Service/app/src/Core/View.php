<?php


namespace Service\Core;


class View
{
    private string $path;
    private array $arguments;

    public function __construct(string $path, array $arguments = [])
    {
        $this->path = $path;
        $this->arguments = $arguments;
    }

    public function show()
    {
        extract($this->arguments, null);
        ob_start();
        include("views/{$this->path}.php");
        return ob_get_clean();
    }
}