<?php

namespace App;

use App\Http\ParenthesesValidator;

class App
{
    protected const REQUEST_PARAM_NAME = 'string';

    public function run()
    {
        try {
            $this->validateRequest();
            $string = $this->getStringFromRequest();
            $this->validateStringParam($string);

            if (!(new ParenthesesValidator())->validate($string)) {
                throw new \InvalidArgumentException(sprintf(
                    'Parameter "%s" is incorrect',
                    self::REQUEST_PARAM_NAME
                ));
            }
        } catch (\Throwable $t) {
            $this->showError($t->getMessage());
            return;
        }

        $this->showMessage(sprintf('Parameter "%s" is correct', self::REQUEST_PARAM_NAME));
    }

    protected function validateRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \InvalidArgumentException('Incorrect request type, only POST available');
        }

        if (!isset($_POST[self::REQUEST_PARAM_NAME])) {
            throw new \InvalidArgumentException(sprintf(
                'Parameter "%s" is required',
                self::REQUEST_PARAM_NAME
            ));
        }
    }

    protected function validateStringParam(string $string)
    {
        if ($string === '') {
            throw new \InvalidArgumentException(sprintf(
                'Parameter "%s" should not be empty',
                self::REQUEST_PARAM_NAME
            ));
        }
    }

    protected function getStringFromRequest(): string
    {
        return trim((string)$_POST[self::REQUEST_PARAM_NAME]);
    }

    protected function showError($message = '')
    {
        http_response_code(400);
        echo $message;
    }

    protected function showMessage($message = '')
    {
        echo $message;
    }
}