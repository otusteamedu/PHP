<?php


namespace Repetitor202;


//use Repetitor202\Adapter\IProducerHtmlNews;
use Repetitor202\Factory\ArticleFactory;
use Repetitor202\Factory\HtmlFactory\ArticleHtmlFactory;
use Repetitor202\Factory\Article;
use Repetitor202\Factory\JsonFactory\ArticleJsonFactory;
use Repetitor202\Proxy\ArticleProxy;
use Repetitor202\Proxy\MegaSuperPuperNewsHtmlService;

class ArticleService
{
    public const FORMAT_HTML = 'html';
    public const FORMAT_JSON = 'json';

    private ArticleFactory $factory;

    public function buildArticleByFactory(
        string $category,
        string $title,
        string $body,
        string $format = self::FORMAT_JSON
    ): ?Article
    {
        $this->setFactory($format);

        switch ($category) {
            case Article::CATEGORY_NEWS:
                $article = $this->factory->makeNews($title, $body);
                break;
            case Article::CATEGORY_REVIEW:
                $article = $this->factory->makeReview($title, $body);
                break;
            default:
                $article = null;
        }

        return $article;
    }

    private function setFactory(string $format): void
    {
        switch ($format) {
            case self::FORMAT_HTML:
                $this->factory = new ArticleHtmlFactory();
                break;
            default:
                $this->factory = new ArticleJsonFactory();
                break;
        }
    }

    public function insertArticleInDatabase(
        string $category,
        string $title,
        string $body,
        string $format = self::FORMAT_JSON
    ): ArticleEloquent
    {
        return ArticleEloquent::create([
            'category' => $category,
            'format' => $format,
            'name' => $title,
            'body' => $body,
        ]);
    }

    public function getNewsArticleFromDatabase(int $id): ?string
    {
        $articleProxy = new ArticleProxy(new MegaSuperPuperNewsHtmlService());

        return $articleProxy->getNewsById($id);
    }
}