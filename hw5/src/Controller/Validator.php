<?php

namespace Sergey\Otus\Controller;

class Validator
{
    public function validate()
    {
        try {
            $value = $_REQUEST['string'];
            $validator = new \Sergey\Otus\Model\Validator();
            $message = '';
            $result = $validator->validate($value, $message);

            if (!$result) {
                throw new \Sergey\Otus\Exception\ValidatorException($message);
            }
        } catch (\Sergey\Otus\Exception\ValidatorException $e) {
            http_response_code(400);
            $view = new \Sergey\Otus\View\Error();
            $view->display($e->getMessage());

            return;
        } catch (\Exception $e) {
            exit ('Internal server error.');
        }

        $view = new \Sergey\Otus\View\Success();
        $view->display($message);
    }
}