<?php


namespace Otus\Controllers;

use Exception;
use Otus\Models\Message;
use Otus\Utils\Rabbit;

/**
 * Class MessagesController
 * @package Otus\Controllers
 */
class MessagesController extends BaseController
{

    /**
     * @throws Exception
     */
    public function getAction()
    {
        $request = $this->getRequest();
        $id  = $request->get('id');
        if (!$id) {
            $this->getResponse()->sendErrorApiResponse('Id is needed', 400);
        }
        $message = Message::findById($id);

        if (!$message) {
            $this->getResponse()->sendErrorApiResponse('No message with id ' . $id, 404);
        }
        $status = $message->getStringStatus();
        $this->getResponse()->sendApiResponse($status);
    }

    /**
     * @throws Exception
     */
    public function sendAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->getResponse()->sendErrorApiResponse('Post request is needed', 400);
        }
        $post = $this->getRequest()->getPost();
        if (array_key_exists('message', $post)) {
            $message = new Message();
            try {
                $message->message = $post['message'];
                $message->save();
                Rabbit::sendMesage(Message::getQueueName(), json_encode(['id' => $message->id]));
                $this->getResponse()->sendApiResponse('Message was send. Id : ' . $message->id);
            } catch (Exception $e) {
                if ($message->id) {
                    $message->delete();
                }
                $this->getResponse()->sendErrorApiResponse($e->getMessage(), $e->getCode());
            }
        } else {
            $this->getResponse()->sendErrorApiResponse('No message in request', 400);
        }
    }
}