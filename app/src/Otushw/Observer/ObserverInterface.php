<?php


namespace Otushw\Observer;

use Otushw\Article;

/**
 * Interface ObserverInterface
 *
 * @package Otushw
 */
interface ObserverInterface
{
    /**
     * @param Article $article
     *
     * @return void
     */
    public function update(Article $article): void;
}