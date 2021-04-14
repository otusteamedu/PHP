<?php


namespace Repetitor202\Factory\HtmlFactory;

use Repetitor202\Factory\News;
use Repetitor202\Adapter\IProducerHtmlNews;

class NewsHtml extends News implements IProducerHtmlNews
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
        $this->factoryBuild .= '<h4>News:HtmlFactoryBuild</h4>';
        $this->factoryBuild .= '<h1>' . $this->title . '</h1>';
        $this->factoryBuild .= '<p>' . $this->body . '</p>';
        $this->factoryBuild .= '</div>';
    }

    public function produceHtmlNews(): string
    {
        $message = '<h4><font color="green">News:IProducerHtmlNews</font></h4>';
        $message .= $this->getTitle();
        $message .= $this->getBody();

        return $message;
    }
}