<?php

namespace View;

class StatisticView extends View
{
    public function output()
    {
        $resultArr = $this->controller->getSaveYoutubeData()['hits']['hits'];
        foreach ($resultArr as $result) {
            echo '<hr>'
                . 'название канала - ' . $result['_id'] . '<br>'
                . 'всего видео - ' . $result['_source']['countVideo'] . '<br>'
                . 'общее число просмотров - ' . $result['_source']['views'] . '<br>'
                . 'в среднем просмотров - ' . ((int)$result['_source']['views'] / (int)$result['_source']['countVideo'])
                . '<br><hr>';
        }
    }
}