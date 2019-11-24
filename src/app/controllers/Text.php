<?php

namespace Controllers;

use Core\AppController;
use Core\AppException;
use Exception;
use Utils\TextValidator;
use Utils\TextValidatorException;
use Utils\ValidatorRules;

class Text extends AppController
{
    /**
     * @throws AppException
     */
    public function validate()
    {
        $str = $_POST["string"] ?? "";
        $rules = new ValidatorRules($this->appConfig->validation);
        $validator = new TextValidator($str ?? "", $rules);

        try {
            $validator->validateLength();
            $validator->validateBrackets();
        } catch (TextValidatorException $e) {
            throw new AppException($e->getMessage());
        }

        $this->response->content = "correct string: {$str}";
    }

}