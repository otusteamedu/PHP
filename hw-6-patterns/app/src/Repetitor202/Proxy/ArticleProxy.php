<?php


namespace Repetitor202\Proxy;


use Repetitor202\Factory\HtmlFactory\NewsHtml;
use Repetitor202\Factory\JsonFactory\NewsJson;
use Repetitor202\ArticleEloquent;
use Repetitor202\ArticleService;
use Repetitor202\Adapter\NewsJsonToHtmlAdapter;
use Repetitor202\Visitor\IsNewsOperationVisitor;

class ArticleProxy
{
    private MegaSuperPuperNewsHtmlService $megaSuperPuperNewsHtmlService;

    public function __construct(MegaSuperPuperNewsHtmlService $megaSuperPuperNewsHtmlService)
    {
        $this->megaSuperPuperNewsHtmlService = $megaSuperPuperNewsHtmlService;
    }

    public function getNewsById(int $id): ?string
    {
        $articleEloquent = ArticleEloquent::find($id);
        if (is_null($articleEloquent)) {
            return null;
        }

        $service = new ArticleService();
        $article = $service->buildArticleByFactory(
            $articleEloquent->category,
            $articleEloquent->name,
            $articleEloquent->body,
            $articleEloquent->format
        );
        $isNewsOperationVisitor = new IsNewsOperationVisitor();

        $article->accept($isNewsOperationVisitor);

        if ($article->isNewsAcceptedByVisitor) {
            if ($article instanceof NewsHtml) {
                $resp = $this->megaSuperPuperNewsHtmlService->build($article->produceHtmlNews());
            } elseif ($article instanceof NewsJson) {
                $htmlAdapter = (new NewsJsonToHtmlAdapter($article));
                $resp = $this->megaSuperPuperNewsHtmlService->build($htmlAdapter->produceHtmlNews());
            } else {
                return null;
            }
        } else {
            return null;
        }

        return $resp;
    }
}