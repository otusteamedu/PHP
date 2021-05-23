<?php
declare(strict_types=1);

namespace DesignPatterns\Observers;

interface Subject
{
    /**
     * @param Observer $observer
     * @param string $event
     *
     * @return void
     */
    public function attach(Observer $observer, string $event): void;

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function detach(Observer $observer): void;

    /**
     * @param string $event
     *
     * @return void
     */
    public function notify(string $event): void;
}
