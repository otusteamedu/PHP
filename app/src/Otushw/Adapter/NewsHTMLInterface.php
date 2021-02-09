<?php


namespace Otushw\Adapter;

/**
 * Interface NewsHTMLInterface
 *
 * @package Otushw\Adapter
 */
interface NewsHTMLInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getBody(): string;

    /**
     * @return string
     */
    public function getCreated(): string;

    /**
     * @return string
     */
    public function getEvent(): string;
}