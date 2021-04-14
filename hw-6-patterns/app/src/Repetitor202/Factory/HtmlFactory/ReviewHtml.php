<?php


namespace Repetitor202\Factory\HtmlFactory;

use Repetitor202\Factory\Review;

class ReviewHtml extends Review
{
    public function __construct(string $title, string $body)
    {
        $this->setTitle($title);
        $this->setBody($body);
        $this->setFactoryBuild();
    }

    public function setFactoryBuild(): void
    {
        $this->factoryBuild = '<div>';
        $this->factoryBuild .= '<h4>Review:HtmlFactoryBuild</h4>';
        $this->factoryBuild .= '<h1>' . $this->title . '</h1>';
        $this->factoryBuild .= '<p>' . $this->body . '</p>';
        $this->factoryBuild .= '</div>';
    }
}