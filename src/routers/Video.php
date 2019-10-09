<?php
declare(strict_types = 1);

namespace Alex\Youtubestat\Routers;

class Video
{
    private $method;
    private $urlData;
    private $formData;

    public function __construct($method, $urlData, $formData)
    {
        $this->method = $method;
        $this->urlData = $urlData;
        $this->formData = $formData;
    }

    public function route()
    {
        // Получение информации о товаре
        // GET /goods/{goodId}
        if ($this->method === 'GET' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $this->get($id);

            return;
        }


        // Добавление нового товара
        // POST /goods
        if ($this->method === 'POST' && empty($this->urlData)) {
            // Добавляем товар в базу...

            $this->post();

            return;
        }


        // Обновление всех данных товара
        // PUT /goods/{goodId}
        if ($this->method === 'PUT' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $this->put($id);


            return;
        }


        // Частичное обновление данных товара
        // PATCH /goods/{goodId}
        if ($this->method === 'PATCH' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $this->patch($id);

            return;
        }


        // Удаление товара
        // DELETE /goods/{goodId}
        if ($this->method === 'DELETE' && count($this->urlData) === 1) {
            // Получаем id товара
            $id = $this->urlData[0];

            $this->delete($id);

            return;
        }


        // Возвращаем ошибку
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(array(
            'error' => 'Bad Request'
        ));

    }

    private function get($id)
    {

        // Вытаскиваем товар из базы...

        // Выводим ответ клиенту
        echo json_encode(array(
            'method' => 'GET',
            'id' => $id,
            'good' => 'phone',
            'price' => 10000
        ));

    }

    private function post()
    {

        // Выводим ответ клиенту
        echo json_encode(array(
            'method' => 'POST',
            'id' => mt_rand(1, 100),
            'formData' => $this->formData
        ));

    }

    private function put($id)
    {

        // Обновляем все поля товара в базе...

        // Выводим ответ клиенту
        echo json_encode(array(
            'method' => 'PUT',
            'id' => $id,
            'formData' => $this->formData
        ));

    }

    private function patch($id)
    {

        // Обновляем только указанные поля товара в базе...

        // Выводим ответ клиенту
        echo json_encode(array(
            'method' => 'PATCH',
            'id' => $id,
            'formData' => $this->formData
        ));

    }

    private function delete($id)
    {

        // Удаляем товар из базы...

        // Выводим ответ клиенту
        echo json_encode(array(
            'method' => 'DELETE',
            'id' => $id
        ));

    }
}

