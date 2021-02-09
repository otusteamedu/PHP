<?php


namespace Otushw\Observer;

use Otushw\Article;

/**
 * Interface Observable
 *
 * @package Otushw
 */
interface Observable
{
    /**
     * @param ObserverInterface $observer
     *
     * @return void
     */
    public function attach(ObserverInterface $observer): void;

    /**
     * @param ObserverInterface $observer
     *
     * @return void
     */
    public function detach(ObserverInterface $observer): void;

    /**
     * @param Article $article
     */
    public function notify(Article $article): void;
}
