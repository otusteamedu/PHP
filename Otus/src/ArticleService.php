<?php


namespace Otus;


use Otus\AbstractFactory\Interfaces\ArticleFactory;
use Otus\AbstractFactory\Interfaces\News;
use Otus\AbstractFactory\Interfaces\Review;
use Otus\Observer\Observable;
use Otus\Observer\Observer;
use Otus\Visitor\Visitor;

class Article implements Observable
{
    private ArticleFactory $factory;
    private News $news;
    private Review $review;

    private $observers;
    private Visitor $visitor;

    public function __construct(ArticleFactory $factory)
    {
        $this->factory = $factory;
        $this->visitor = new Visitor();
    }

    public function createNews()
    {
        $this->news = $this->factory->createNews();
        $this->news->accept($this->visitor);
        //клиент или внутренний метод должен вызывать метод notify()?
        $this->notify();
    }

    public function createReview()
    {
        $this->review = $this->factory->createReview();
        $this->notify();
    }

    public function getNews()
    {
        $this->news->getNews();
    }

    public function setNews(News $news)
    {
        $this->news = $news;
    }

    public function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer)
    {
        foreach ($this->observers as &$search){
            if($search == $observer){
                unset($search);
            }
        }
    }

    public function notify()
    {
        /** @var Observer $observer */
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}
