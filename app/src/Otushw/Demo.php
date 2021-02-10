<?php


namespace Otushw;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Factory\ArticleFactory;
use Otushw\Factory\HTML\HTMLArticleFactory;
use Otushw\Factory\XML\XMLArticleFactory;
use Otushw\Observer\LoggerObserver;
use Otushw\Visitor\SeparatorNews;

class Demo
{

    const LENGTH_RANDOM_STRING = 5;

    private Collection $collection;

    /**
     * Demo constructor.
     */
    public function __construct()
    {
//        $factory = $this->getFactory('XML');
//        $factory->attach(new LoggerObserver());
//
//        $rawNews = new NewsDTO(
//            $this->generateRandomProperty('title'),
//            $this->generateRandomProperty('body'),
//            time(),
//            $this->generateRandomProperty('event')
//        );
//        $news = $factory->createNews($rawNews);
////        $factory->renderNews($news);
////
//        $rawReviwes = new ReviewsDTO(
//            $this->generateRandomProperty('title'),
//            $this->generateRandomProperty('body'),
//            time(),
//            $this->generateRandomProperty('nameProduct')
//        );
//        $reviews = $factory->createReviews($rawReviwes);
//        $factory->renderReviews($reviews);
    }


    private function generateArticles(): Collection
    {
        $collection = new Collection();

        $factories[] = $this->getFactory('HTML');
        $factories[] = $this->getFactory('XML');

        foreach ($factories as $factory) {
            $factory->attach(new LoggerObserver());

            for ($i = 0; $i < 5; $i++) {
                $rawNews = new NewsDTO(
                    $this->generateRandomProperty('title'),
                    $this->generateRandomProperty('body'),
                    time(),
                    $this->generateRandomProperty('event')
                );
                $news = $factory->createNews($rawNews);
                $collection->add($news);
                $rawReviwes = new ReviewsDTO(
                    $this->generateRandomProperty('title'),
                    $this->generateRandomProperty('body'),
                    time(),
                    $this->generateRandomProperty('nameProduct')
                );
                $reviews = $factory->createReviews($rawReviwes);
                $collection->add($reviews);
            }
        }

        return $collection;
    }

    /**
     * @param string $typeFactory
     *
     * @return ArticleFactory
     */
    private function getFactory(string $typeFactory): ArticleFactory
    {
        switch ($typeFactory) {
            case 'HTML':
                return new HTMLArticleFactory();
            case 'XML':
                return new XMLArticleFactory();
        }
    }

    private function generateRandomProperty(string $property): string
    {
        return $property . '_' . bin2hex(random_bytes(self::LENGTH_RANDOM_STRING));
    }

    private function separatorNews()
    {
        $separator = new SeparatorNews($this->collection);
        $buf = clone $this->collection;
        foreach ($buf as $article) {
            $article->accept($separator);
        }
    }

    private function transformFormat()
    {
        $buf = clone $this->collection;
        foreach ($buf as $key => $article) {
            if (!($article instanceof NewsHTML)) {
                $adapter = new NewsHTMLAdapter($article);
                $this->collection->delete($article);
                $this->collection->add($adapter);
                Message::showMessage('Adapter: I will use NewsHTMLAdapter');
            }
        }
    }

    private function showNews()
    {
        Message::showMessage("************************************");
        Message::showMessage("I'll show you News");
        foreach ($this->collection as $newsHTML) {
            Message::showMessage('Title ' . $newsHTML->getTitle());
            Message::showMessage('Body ' . $newsHTML->getBody());
            Message::showMessage('Created ' . $newsHTML->getCreated());
            Message::showMessage('Event '. $newsHTML->getEvent());
            Message::showMessage("#########################################");
        }
    }

    private function showProxy()
    {
        Message::showMessage('Example Proxy');
        $this->collection->rewind();
        $proxy = new Proxy($this->collection->current());
        Message::showMessage($proxy->getTitle());
        Message::showMessage($proxy->getTitle());
    }

}
