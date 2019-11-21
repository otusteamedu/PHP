<?php

namespace Controllers;

use Core\AppException;
use Exception;
use Utils\TextValidator;
use Utils\ValidatorRules;

class Text extends AppController
{
    /**
     * @param string|null
     * @throws AppException
     */
    public function validate()
    {
        $str = $_POST["string"] ?? "";
        $rules = new ValidatorRules($this->appConfig->textRules);
        $validator = new TextValidator($str ?? "", $rules);

        try {
            $validator->validateLength();
            $validator->validateBrackets();
        } catch (Exception $e) {
            throw new AppException($e->getMessage());
        }

        $this->response->content = "correct string: {$str}";
    }

}