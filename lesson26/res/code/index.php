<?php

include('vendor/autoload.php');

use Otus\Models\Message;
use Otus\Utils\Rabbit;

function sendBadCode($message = '')
{
    header("HTTP/1.1 400 Bad Request", false);
    header("Status: 400 Bad Request", false);
    header('Content-Type: application/json', false);
    echo $message;
}

function sendOkCode($message = '')
{
    header("HTTP/1.1 200 OK", false);
    header("Status: 200 All ok", false);
    header('Content-Type: application/json', false);
    echo $message;
}

function getMessageStatus()
{
    if (!isset($_GET['id'])) {
        throw new Exception('Id is needed', 400);
    }
    $message = Message::findById($_GET['id']);

    if (!$message) {
        throw new Exception('No message with id ' . $_GET['id'], 404);
    }
    return Message::$statuses[$message->status];
}

function getAction()
{
    try {
        $status = getMessageStatus();
        $message['message'] = 'Message with id "' . $_GET['id'] . '" has status "' . $status . '".';
        sendOkCode(json_encode($message));
    } catch (Exception $e) {
        $message['code'] = $e->getCode();
        $message['error'] = $e->getMessage();
        sendBadCode(json_encode($message));
    }
}

function sendAction()
{
    $responseMessage = array();
    if (array_key_exists('message', $_POST)) {
        $message = new Message();
        try {
            $message->message = $_POST['message'];
            $message->save();
            Rabbit::sendMesage(Message::getQueueName(), json_encode(['id' => $message->id]));
            sendOkCode(json_encode(['message' => 'Message was send. Id : ' . $message->id]));
        } catch (Exception $e) {
            if ($message->id) {
                $message->delete();
            }
            $responseMessage['code'] = $e->getCode();
            $responseMessage['error'] = $e->getMessage();
        }
    } else {
        $responseMessage['code'] = 400;
        $responseMessage['error'] = 'No message in request';
    }
    sendBadCode(json_encode($responseMessage));
}

$path = parse_url(($_SERVER['REQUEST_URI']), PHP_URL_PATH);
switch ($path) {
    case '/message/get':
        getAction();
        break;
    case '/message/send':
        sendAction();
        break;
    default:
        sendBadCode(json_encode(['error' => 'Wrong request', 'code' => 400]));
        break;
}
exit();