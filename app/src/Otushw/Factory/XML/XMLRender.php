<?php


namespace Otushw\Factory\XML;

use Otushw\Factory\Article;
use Otushw\Factory\Render;
use DOMDocument;

class XMLRender extends Render
{
    private string $xmlRoot;

    public function __construct(string $templateName)
    {
        $this->xmlRoot = $templateName;
    }

    public function render(Article $article): void
    {
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $xmlRoot = $domtree->createElement("xml");
        $xmlRoot = $domtree->appendChild($xmlRoot);
        $elementArticle = $domtree->createElement($this->xmlRoot);
        $elementArticle = $xmlRoot->appendChild($elementArticle);

        $elements = $this->prepareProperty($article);
        foreach ($elements as $name => $value) {
            $elementArticle->appendChild($domtree->createElement($name, $value));
        }
        Header('Content-type: text/xml');
        echo $domtree->saveXML();
    }

    protected function generatePropertyName(string $propertyName): string
    {
        return strtolower($propertyName);
    }

}
