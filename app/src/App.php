<?php

namespace App;

class App
{
    private $server;
    private $input;

    public function __construct($server, $input)
    {
        $this->server = $server;
        $this->input = $input;
    }

    public function run()
    {
        // Проверка что запрос является POST-запросом
        if ($this->server['REQUEST_METHOD'] != 'POST') {
            $this->sendErrorCode(405);
        }

        // Проверка, что полученные данные имеют тип json
        if ($this->server['CONTENT_TYPE'] != 'application/json') {
            $this->sendErrorCode(415);
        }

        // Проверка, что клиент передал строку
        if (empty($this->input)) {
            $this->sendErrorCode(422);
        }

        $data = json_decode($this->input, true);

        // Клиент передал ошибочный json
        if (is_null($data)) {
            $this->sendErrorCode(422);
        }

        // Клиент не передал ключ emails, или содержимое не является массивом
        if (!array_key_exists('emails', $data) || !is_array($data['emails'])) {
            $this->sendErrorCode(422);
        }

        $emails = $data['emails'];

        $response = [];

        // Проверка Email-адресов
        try {
            foreach ($emails as $email) {
                if (!is_string($email)) {
                    $this->sendErrorCode(422);
                }
                $regexValidator = new RegexValidator($email);
                $regexIsValid = $regexValidator->execute();
                $dnsIsValid = false;
                if ($regexIsValid) {
                    $dnsValidator = new DNSValidator($email);
                    $dnsIsValid = $dnsValidator->execute();
                }
                $response[] = [
                    'email' => $email,
                    'regex' => $regexIsValid,
                    'dns' => $dnsIsValid,
                ];
            }
        } catch (\Exception $e) {
            $this->sendErrorCode(500);
        }

        $this->sendResponse($response);
    }

    /**
     * Отправка HTTP-кода ошибки клиенту
     * @param $code
     */
    private function sendErrorCode($code)
    {
        http_response_code($code);
        exit;
    }

    /**
     * Отправка ответа клиенту
     * @param array $response
     */
    private function sendResponse($response)
    {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response);
        exit;
    }
}
