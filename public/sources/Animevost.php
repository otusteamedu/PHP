<?php

namespace Sources;

class Animevost implements \Sources\MethodsInterface {
    public function getTop() : Array
    {
        $result = [];

        $dom = \phpQuery::newDocument(file_get_contents('https://animevost.am/'));

        $elements = $dom->find('#dle-content .shortstory');

        foreach ($elements as $key=>$element) {
            if ($key == 2) {
            $result[] = [
                'title' => pq($element)->find('.shortstoryHead h2 a')->text(),
                'category' => pq($element)->find('.shortstoryFuter span i')->text(),
                'link' => pq($element)->find('.shortstoryFuter a')->attr('href')
            ];
            
        }}

        return $result;
    }

    public function getAll() : Array
    {

    }

    public function getPage(int $page) : Array
    {

    }
}
