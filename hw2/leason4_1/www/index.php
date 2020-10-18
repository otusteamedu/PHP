<?php
include 'src/autoload.php';

const minLength = 20;

$request  = new HttpRequest();
$response = new HttpResponse();

if ($request->isPost()) {
    $data = $request->getParam('string');
    if ( ! empty($data) && strlen($data) > minLength) {
        $checker = new Checker();
        if ($checker->check($data)) {
            $response->send(200, 'Последовательность верная');
        } else {
            $response->send(500, 'Последовательность не верная');
        }
    } else {
        $response->send(500, 'Не корректная длина строки');
    }
} else {
    $response->send(500, 'Необходимо отправить POST-запрос');
}
