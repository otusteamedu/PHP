<?php


namespace AYakovlev\Controller;

use AYakovlev\Core\View;
use AYakovlev\Model\Article;
use AYakovlev\Model\User;

class ArticleController
{
    private View $view;
    private int $idArticle;

    public function __construct()
    {
        $this->view = new View();
    }

    public function getIdArticle(): int
    {
        return $this->idArticle;
    }

    public function setIdArticle(int $idArticle): void
    {
        $this->idArticle = $idArticle;
    }

    public function view(): void
    {
        $data = Article::getById($this->idArticle);

        if ($data === null) {
            View::render("404", (array) $this->idArticle, 404);
            return;
        }

        $articleAuthor = User::getById($data->getAuthorId());

        View::render("article", [
            'data' => $data,
            'author' => $articleAuthor
        ]);
    }

    public function edit(): void
    {
        $data = Article::getById($this->idArticle);

        if ($data === null) {
            View::render("404", (array) $this->idArticle, 404);
            return;
        }

        $data->setName('New article name');
        $data->setText('New article text');

        $data->save();

        View::render("edit", []);

    }

    public function add(): void
    {
        $author = User::getById(1);

        $data = new Article();
        $data->setAuthor($author);
        $data->setName('Сущность-Атрибут-Значение');
        $data->setText('Модель Сущность-Атрибут-Значение (EAV) - это модель данных, предназначенная для описания сущностей, в которых количество атрибутов (свойств, параметров), характеризующих их, потенциально огромно, но то количество, которое реально будет использоваться в конкретной сущности, относительно мало.');

        $data->save();

        View::render("add", []);

    }

    public function delete(): void
    {
        $data = Article::getById($this->idArticle);

        if ($data === null) {
            View::render("404", (array) $this->idArticle, 404);
            return;
        }

        $data->delete();
        View::render("delete", []);
    }
}
