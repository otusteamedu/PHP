<?php

namespace App\Core\Templates;

use App\Core\RenderObserver\Observable;
use App\Core\RenderObserver\ObserverInterface;
use App\Core\Templates\TemplateAbstractFactory\Factory\PHPTemplateFactory;
use App\Core\Templates\TemplateAbstractFactory\Factory\TwigTemplateFactory;

class RenderPage implements Observable
{
    private array $observers;

    public function renderEntityByPHP(Page $page): void
    {
        $page->renderEntity(new PHPTemplateFactory());
        $this->notifyObservers();
    }

    public function renderEntityByTwig(Page $page): void
    {
        $page->renderEntity(new TwigTemplateFactory());
        $this->notifyObservers();
    }

    public function addObserver(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(ObserverInterface $observer): void
    {
        foreach ($this->observers as &$search) {
            if ($search === $observer) {
                unset($search);
            }
        }
    }

    public function notifyObservers(): void
    {
        foreach ($this->observers as $observer) {
            /* @var $observer ObserverInterface */
            $observer->update($this);
        }
    }
}