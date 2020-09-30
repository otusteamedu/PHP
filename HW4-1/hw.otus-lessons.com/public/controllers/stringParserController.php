<?php


namespace App\Controllers;


use App\Util;

class stringParserController extends ModelController
{
    public function checkAction()
    {
        $get_string = $this->di->request->get('string');
        if (!$get_string) {
            $this->di->dispatcher->dispatch(
                [
                    'controller' => 'ErrorController',
                    'action' => 'errorAction',
                    'params' => [400, 'Bad request. Empty string.'],
                ]
            );
            return;
        }
        if (strlen($get_string) > 50) {
            $this->di->dispatcher->dispatch(
                [
                    'controller' => 'ErrorController',
                    'action' => 'errorAction',
                    'params' => [400, 'Too large string.'],
                ]
            );
            return;
        }
        $patterns = $this->di->config['parseString'];
        $correct_string = false;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $get_string)) {
                $correct_string = true;
                break;
            }
        }
        if (!$correct_string) {
            $this->di->dispatcher->dispatch(
                [
                    'controller' => 'ErrorController',
                    'action' => 'errorAction',
                    'params' => [400, 'Bad request. Incorrect string'],
                ]
            );
            return;
        }


        echo "Все ок!";
    }
}