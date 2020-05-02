<?php

namespace Bjlag\Template\Adapters;

use Bjlag\App;
use Bjlag\Template\Template;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig implements Template
{
    /** @var \Twig\Environment */
    private $twig;

    /**
     * @param string $cacheDir
     */
    public function __construct(string $cacheDir)
    {
        $loader = new FilesystemLoader(App::getContainer()->get('template_dir'));
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
    }

    /**
     * @param string $path
     * @param array $params
     * @return string
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $path, array $params = []): string
    {
        return $this->twig
            ->load("{$path}.twig")
            ->render($params);
    }
}
