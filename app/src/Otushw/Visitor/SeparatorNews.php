<?php


namespace Otushw\Visitor;

use Otushw\Collection;
use Otushw\Message;
use Otushw\Models\News;
use Otushw\Models\Reviews;

/**
 * Class SeparatorNews
 *
 * @package Otushw\Visitor
 */
class SeparatorNews implements Visitor
{

    const PREFIX_MSG = 'Visitor is checking: ';

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * SeparatorNews constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param News $news
     *
     * @return void
     */
    public function visitNews(News $news): void
    {
        Message::showMessage(self::PREFIX_MSG . 'This is News, I will not delete it.');
    }

    /**
     * @param Reviews $reviews
     *
     * @return void
     */
    public function visitReviews(Reviews $reviews): void
    {
        Message::showMessage(self::PREFIX_MSG . 'This is Reviews, I will delete it.');
        $this->collection->delete($reviews);
    }

}