<?php


namespace Otushw;

use Otushw\Adapter\NewsHTMLAdapter;
use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Factory\ArticleFactory;
use Otushw\Factory\HTML\HTMLFactory;
use Otushw\Factory\HTML\NewsHTML;
use Otushw\Factory\XML\XMLFactory;
use Otushw\Observer\LoggerObserver;
use Otushw\Observer\MessageObserver;
use Otushw\Proxy\Proxy;
use Otushw\Visitor\SeparatorNews;

/**
 * Class Demo
 *
 * @package Otushw
 */
class Demo
{

    const LENGTH_RANDOM_STRING = 5;

    private Collection $collection;

    /**
     * Demo constructor.
     */
    public function __construct()
    {
        $this->collection = $this->generateArticles();
        $this->separatorNews();
        $this->transformFormat();
        $this->showNews();
        $this->showProxy();
    }


    /**
     * @return Collection
     */
    private function generateArticles(): Collection
    {
        $collection = new Collection();

        $factories[] = self::getFactory('HTML');
        $factories[] = self::getFactory('XML');

        foreach ($factories as $factory) {
            $factory->attach(new LoggerObserver());
            $factory->attach(new MessageObserver());

            for ($i = 0; $i < 5; $i++) {
                $rawNews = new NewsDTO(
                    self::generateRandomProperty('title'),
                    self::generateRandomProperty('body'),
                    time(),
                    self::generateRandomProperty('event')
                );
                $news = $factory->createNews($rawNews);
                $collection->add($news);
                $rawReviwes = new ReviewsDTO(
                    self::generateRandomProperty('title'),
                    self::generateRandomProperty('body'),
                    time(),
                    self::generateRandomProperty('nameProduct')
                );
                $reviews = $factory->createReviews($rawReviwes);
                $collection->add($reviews);
            }
        }

        $numArticles = $collection->getTotal();
        Message::showMessage('Articles total: ' . $numArticles);

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
                return new HTMLFactory();
            case 'XML':
                return new XMLFactory();
        }
    }

    /**
     * @param string $property
     *
     * @return string
     * @throws \Exception
     */
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

        $num = $this->collection->getTotal();
        Message::showMessage('Visitor left only ' . $num . ' articles and they are News');
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
