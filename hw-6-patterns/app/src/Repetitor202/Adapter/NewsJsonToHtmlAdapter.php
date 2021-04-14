<?php


namespace Repetitor202\Adapter;

use Repetitor202\Factory\JsonFactory\NewsJson;

class NewsJsonToHtmlAdapter implements IProducerHtmlNews
{
    protected NewsJson $newsJson;

    public function __construct(NewsJson $newsJson)
    {
        $this->newsJson = $newsJson;
    }

    public function produceHtmlNews(): string
    {
        $message = '<h4><font color="green"> News:IProducerHtmlNews</font></h4>';
        $message .= '<p><font color="blue">TODO:</font> json to html</p>';

        $message .= '<h4 style="background-color: chartreuse">NewsJsonToHtmlAdapter</h4>';
        $message .= $this->newsJson->getTitle();
        $message .= $this->newsJson->getBody();

        return $message;
    }
}