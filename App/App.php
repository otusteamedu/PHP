<?php


namespace App;


use App\Commands\Command;
use App\Exceptions\IsNullException;
use App\Validators\BracketValidator;
use App\Validators\EmailValidator;
use App\Validators\Validator;

class App
{

    private $responceCode = 200;
    private $responce = null;

    public function run()
    {
        if ($this->hasCommand()) {
            Command::run($GLOBALS['argv'][1], array_slice($GLOBALS['argv'], 2));
        }
        if (Request::isPost()) {
            $this->responce = $this->validPost([
                'string'    => BracketValidator::class,
                //Example: test@mail.ru is valid, but test@gmail.ru is invalid
                'email'     => (new EmailValidator())
                    ->setDeniedRootDomains(['gmail'])
                    ->setAllowedRootDomains(['mail']),
                'email_two' => EmailValidator::class
            ]);
        }
        return $this->responce;
    }


    private function hasCommand(): bool
    {
        return !empty($GLOBALS['argv'][1]);
    }

    public function validPost(array $fields)
    {
        $result = 'OK';
        try {
            foreach ($fields as $field => $validator) {
                if (is_subclass_of($validator, Validator::class) === false) {
                    throw new \InvalidArgumentException("Validator must implement " . Validator::class);
                }
                if (array_key_exists($field, $_POST)) {
                    $value = $_POST[$field];
                    $validator = $validator instanceof Validator ? $validator : new $validator;
                    if ($value === null) {
                        throw  new IsNullException('string');
                    }
                    if ($value === '') {
                        throw new IsNullException('string');
                    }
                    if (!$validator->setValue($value)->validate()->isValid()) {
                        throw new \ErrorException("The field [$field] is not valid by " . get_class($validator));

                    }
                }
            }

        } catch (\Throwable $e) {
            $this->responceCode = 400;
            $result = $e->getMessage();
        }
        return $result;
    }
}