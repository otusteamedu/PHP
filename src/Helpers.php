<?php
declare(strict_types = 1);

namespace Alex\Youtubestat;


class Helpers
{
    /**
     * @param $method
     * @return array
     */
    public function getFormData(string $method) {

        // GET или POST: данные возвращаем как есть
        if ($method === 'GET') return $_GET;
        if ($method === 'POST') return $_POST;

        // PUT, PATCH или DELETE
        $data = array();
        $exploded = explode('&', file_get_contents('php://input'));

        foreach($exploded as $pair) {
            $item = explode('=', $pair);
            if (count($item) == 2) {
                $data[urldecode($item[0])] = urldecode($item[1]);
            }
        }

        return $data;
    }

    public function queueAdd()
    {

    }

    public function queueGet($id)
    {

    }

}