<?php declare(strict_types=1);

namespace Otus;


class App
{
    public function run(): void
    {
        if (isset($_REQUEST["string"])) {
            $brackets = new Brackets();
            if ($brackets->check($_REQUEST["string"])) {
                $this->displaySuccess();
            } else {
                $this->displayErrors($brackets->getErrors());
            }
        } else {
            $this->displayErrors(["Не передан параметр string"]);
        }
    }


    private function displaySuccess(): void
    {
        header("");
        $output = [
            "status" => "success",
            "data" => "Данные прошли валидацию!",
        ];
        echo json_encode($output);
    }


    private function displayErrors(array $errors): void
    {
        header("HTTP/1.1 400 Bad Request");
        $output = [
            "status" => "error",
            "errors" => $errors,
        ];
        echo json_encode($output);
    }
}