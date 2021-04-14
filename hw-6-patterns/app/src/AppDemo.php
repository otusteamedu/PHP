<?php


namespace App;


use Repetitor202\ArticleService;
use Repetitor202\Factory\Article;
use Repetitor202\Observer\ObservableArticleManager;
use Repetitor202\Observer\ArticleObserver\EchoArticleObserver;


class AppDemo
{
    private ObservableArticleManager $observableManager;

    public function run(): void
    {
        $this->observableManager = new ObservableArticleManager();
        $this->observableManager->attach(new EchoArticleObserver());

        $this->createArticle(Article::CATEGORY_NEWS, ArticleService::FORMAT_JSON);
        $this->createArticle(Article::CATEGORY_NEWS, ArticleService::FORMAT_HTML);
        $this->createArticle(Article::CATEGORY_REVIEW, ArticleService::FORMAT_JSON);
        $this->createArticle(Article::CATEGORY_REVIEW, ArticleService::FORMAT_HTML);

        $this->printNewsArticle(1);
        $this->printNewsArticle(2);
        $this->printNewsArticle(3);
        $this->printNewsArticle(4);
    }

    private function createArticle(string $category, string $format): void
    {
        $postfix = ' - demo - ' . $category . ' - ' . $format;
        $service = new ArticleService();
        $article = $service->buildArticleByFactory(
            $category,
            'title' . $postfix,
            'body' . $postfix,
            $format
        );

        $this->observableManager->notify($article);

        $service->insertArticleInDatabase(
            $category,
            $article->getTitle(),
            $article->getBody(),
            $format
        );
    }

    private function printNewsArticle(int $id): void
    {
        $service = new ArticleService();
        $newsArticle = $service->getNewsArticleFromDatabase($id);

        if (is_null($newsArticle)) {
            echo '<p><font color="red">Bad request.</font></p>';
        } else {
            echo $newsArticle;
        }
    }
}