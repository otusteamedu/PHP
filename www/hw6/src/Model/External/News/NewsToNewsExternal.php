<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\External\News;

use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use Nlazarev\Hw6\Model\ArticleContent\NewsContent\NewsContent;
use Nlazarev\Hw6\Model\Article\News\INews;

class NewsToNewsExternal extends NewsContent implements INewsContent
{
    private NewsExternal $news_external;
    private string $file_path;

    public function __construct(INews $news, NewsExternal $news_external, string $file_path)
    {
        $this->setNews($news);
        $this->news_external = $news_external;
        $this->file_path = $file_path;
    }

    public function getContent()
    {
        $this->news_external->clear();
        $this->news_external->addText($this->getNews()->getHeader());
        $this->news_external->addText("\n");
        $this->news_external->addText($this->getNews()->getMainText());
        $this->news_external->addText("\n");
        $this->news_external->addText($this->getNews()->getSource());
        $this->news_external->addText("\n");

        return $this->news_external->save($this->file_path);
    }
}
