<?php

namespace Otus\App;

use Otus\File\File;
use \Exception;
use Otus\Validator\Validator;

class App
{
    private const STRING_LENGTH_MIN = 2;
    private const STRING_LENGTH_MAX = 256;

    public function run(): void
    {
        $responseCode = 200;
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $success = $this->postHandler();
                $params['success'] = $success;
            } catch (Exception $exception) {
                $params['error'] = $exception->getMessage();
                $responseCode = 400;
            }
        }

        $this->pageRender('index', $params);

        if(isset($error)) {
            http_response_code($responseCode);
        }
    }

    private function postHandler(): string
    {
        if(empty($_POST['string'])) {
            throw new Exception('Строка не может быть пустой');
        } elseif(strlen($_POST['string']) < self::STRING_LENGTH_MIN || strlen($_POST['string']) > self::STRING_LENGTH_MAX) {
            throw new Exception('Не корректная длина строки');
        } elseif (strlen(str_replace(')', '', str_replace('(', '', $_POST['string']))) > 0) {
            throw new Exception('Строка содержит символы, отличные от скобкок');
        } else {
            // Check brackets sequence
            $bracketCount = 0;
            for($i = 0; $i < strlen($_POST['string']); $i++) {
                if($_POST['string'][$i] === '(') {
                    $bracketCount++;
                } else {
                    $bracketCount--;
                }
                // Check wrong brackets sequence
                if($bracketCount < 0) {
                    break;
                }
            }
            // Check wrong brackets count
            if($bracketCount !== 0) {
                throw new Exception('Не верная последовательность или количество открытых и закрытых скобок');
            } else {
                $success = 'Количество открытых и закрытых скобок совпадает';
            }
        }

        return $success;
    }

    private function pageRender(string $page, array $params = null): void
    {
        // Render the page
        include_once(__DIR__ . DIRECTORY_SEPARATOR . '..' .
            DIRECTORY_SEPARATOR . '..' .
            DIRECTORY_SEPARATOR . '..' .
            DIRECTORY_SEPARATOR . 'views' .
            DIRECTORY_SEPARATOR . $page . '.php');
    }
}