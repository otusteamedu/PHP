<?php

namespace App;
/**
 * Class Validation
 * @package App
 */
class Validation
{

    private $data;
    private $errors = [];
    private $rules;

    private $errorsMessage = [
        'require' => 'This field is required.',
        'email' => 'this field is not an email.',
        'mx' => 'this field does not pass the mx test.',
    ];

    /**
     * @return $this
     * @throws ValidationException
     */
    public function make()
    {
        $this->beforeMake();

        foreach ($this->rules as $rulesField => $rules)
        {
            $arrayRules = explode('|', $rules);
            $field = $this->data[$rulesField];

            if(empty($arrayRules))
                throw new ValidationException(ValidationException::EXCEPTION_RULES, Message::STATUS_INTERNAL_SERVER_ERROR);

            foreach ($arrayRules as $arrayRule) {
                $method = 'isValid'. ucfirst($arrayRule);

                if(!method_exists($this, $method))
                    throw new ValidationException($arrayRule. ' '. ValidationException::EXCEPTION_RULES_NOT_FOUNT, Message::STATUS_UNPERFORMED);;

                if(!$this->{"$method"}($field)) {
                    $this->setError($rulesField, $arrayRule);
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $data
     * @return Validation
     */
    public function setData(array $data) : Validation
    {
        $this->data = $data;
        return  $this;
    }

    /**
     * @param array $rules
     * @return Validation
     */
    public function setRules(array $rules): Validation
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @param $field
     * @return bool
     */
    private function isValidRequire($field) : bool
    {
        return $field || !empty($field);
    }

    /**
     * @param $field
     * @return bool
     */
    private function isValidEmail($field) : bool
    {
        return filter_var($field, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param $field
     * @return bool|mixed
     */
    private function isValidMx($field) : bool
    {
        list($user, $domain) = explode('@', $field);
        if(!$domain) return false;
        return checkdnsrr($domain, 'MX');
    }

    /**
     * @param $field
     * @param $rule
     * @return Validation
     */
    private function setError(string $field, string $rule): Validation
    {
        if(!$this->errors[$field]) {
            $this->errors[$field] = [$this->errorsMessage[$rule]];
        } else {
            array_push( $this->errors[$field], $this->errorsMessage[$rule]);
        }
        return $this;
    }

    /**
     * @throws ValidationException
     */
    private function beforeMake()
    {
        if(empty($this->rules))
            throw new ValidationException(ValidationException::EXCEPTION_RULES, Message::STATUS_INTERNAL_SERVER_ERROR);
        if(empty($this->data))
            throw new ValidationException(ValidationException::EXCEPTION_DATA, Message::STATUS_INTERNAL_SERVER_ERROR);
    }

}
