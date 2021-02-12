<?php


namespace Otushw\Adapter;

use Otushw\Factory\Article;
use Otushw\Factory\Render;

class HTMLNewsAdapter implements HTMLNewsInterface
{
    private Article $article;

    public function __construct(Article $article, Render $render)
    {
        $this->article = $article;
        $this->article->setRender($render);
    }

    public function render()
    {
        $this->article->render();
    }
}
