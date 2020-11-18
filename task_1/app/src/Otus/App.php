<?php

namespace Otus;

class App
{
    public function run()
    {
        if (isset($_POST['string'])) {
            $validator = new StringValidator($_POST['string']);
            if ($validator->validate()) {
                $this->successOutput();
            } else {
                $this->failedOutput($validator->getError());
            }
        } else {
            $this->failedOutput('Не передан POST-параметр string');
        }
    }

    private function successOutput()
    {
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        $result = [
            'status' => 'success',
            'message' => 'Данные корректны'
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    private function failedOutput($error)
    {
        header("HTTP/1.1 400 Bad Request");
        header('Content-Type: application/json');
        $result = [
            'status' => 'error',
            'message' => $error
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}