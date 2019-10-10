<?php
declare(strict_types = 1);

namespace Alex\Youtubestat\Routers;
use Alex\Youtubestat\Config;
use Alex\Youtubestat\Helpers;

class Video
{
    private $method;
    private $urlData;
    private $formData;
    private $config;

    public function __construct($method, $urlData, $formData)
    {
        $this->method = $method;
        $this->urlData = $urlData;
        $this->formData = $formData;
        $this->config = new Config();
    }

    public function route()
    {
        $helpers = new Helpers();
        // Получение информации о товаре
        // GET /goods/{goodId}
        if ($this->method === 'GET' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $resultId = $helpers->queueAdd($this->config->request_list_video_name, $id);

            $response_data = ['resultId' => $resultId];

            $helpers->sendResponse(200, $response_data);

            //$this->get($id);

            return;
        }

        if ($this->method === 'GET' && count($this->urlData) === 2 && strtolower($this->urlData[0]) === 'result') {
            // Получаем id товара
            $resultId = $this->urlData[1];

            $response_data = $this->get($resultId);

            if (empty($response_data)) {
                $helpers->sendResponse(404,['info' => 'Result not found']);
                return;
            }

            $helpers->sendResponse(200,['info' => json_decode($response_data, true)]);

            return;
        }

        // for POST
        if ($this->method === 'POST' && empty($this->urlData)) {

            //add something

            $this->post();

            return;
        }


        // for PUT
        if ($this->method === 'PUT' && count($this->urlData) === 1) {
            $id = $this->urlData[0];

            $this->put($id);

            return;
        }


        // for PATCH
        if ($this->method === 'PATCH' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $this->patch($id);

            return;
        }


        // for DELETE
        if ($this->method === 'DELETE' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $this->delete($id);

            return;
        }


        // return error if not from above cases
        $helpers->sendResponse(400);

    }

    private function get($resultId)
    {

        $helpers = new Helpers();
        return $helpers->queueGet($resultId);

    }

    private function post()
    {

        // test response
        echo json_encode(array(
            'method' => 'POST',
            'id' => mt_rand(1, 100),
            'formData' => $this->formData
        ));

    }

    private function put($id)
    {

        // test response
        echo json_encode(array(
            'method' => 'PUT',
            'id' => $id,
            'formData' => $this->formData
        ));

    }

    private function patch($id)
    {

        // test response
        echo json_encode(array(
            'method' => 'PATCH',
            'id' => $id,
            'formData' => $this->formData
        ));

    }

    private function delete($id)
    {

        // test response
        echo json_encode(array(
            'method' => 'DELETE',
            'id' => $id
        ));

    }
}

