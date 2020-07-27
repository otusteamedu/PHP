<?php


namespace AYakovlev\Controller;


use AYakovlev\Core\View;
use AYakovlev\Model\Article;

class BlogController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index(): void
    {
        echo "Index";
    }

    public function articles()
    {
        $data = Article::getAll();
        View::render("articles", $data);
    }

}