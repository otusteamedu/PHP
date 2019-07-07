<?php

use App\DNSValidator;
use App\RegexValidator;

require_once 'vendor/autoload.php';

/**
 * Принимает POST-запрос, с json, содержащим список Email-адресов. Для каждого адреса производит
 * 2 вида валидации: 1) проверка регулярным выражением; 2) проверка MX-записи в DNS.
 * Возвращает в ответ результат обоих проверок для каждого из Email-адресов. Если адрес
 * не прошел проверку регулярным выражением, проверка DNS для него не выполняется
 */

header('Content-Type: application/json; charset=UTF-8');

// Проверка что запрос является POST-запросом
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    exit;
}

// Проверка, что переданные данные имеют тип json
if ($_SERVER['CONTENT_TYPE'] != 'application/json') {
    http_response_code(415);
    exit;
}

$input = trim(file_get_contents('php://input'));

// Проверка, что клиент передал строку
if (empty($input)) {
    http_response_code(422);
    exit;
}

$data = json_decode($input, true);

// Клиент передал ошибочный json
if (is_null($data)) {
    http_response_code(422);
    exit;
}

// Клиент не передал ключ emails, или содержимое не является массивом
if (!array_key_exists('emails', $data) || !is_array($data['emails'])) {
    http_response_code(422);
    exit;
}

$emails = $data['emails'];

$response = [];

try {
    foreach ($emails as $email) {
        if (!is_string($email)) {
            http_response_code(422);
            exit;
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
    http_response_code(500);
    exit;
}

echo json_encode($response);
