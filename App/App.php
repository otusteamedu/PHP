<?php


namespace App;


use App\Commands\Command;
use App\Exceptions\IsNullException;
use App\Validators\BracketValidator;
use App\Validators\Validator;

class App
{
    public function run()
    {
        if ($this->hasCommand()) {
            Command::run($GLOBALS['argv'][1], array_slice($GLOBALS['argv'], 2));
        }

    }

    private function hasCommand(): bool
    {
        return !empty($GLOBALS['argv'][1]);
    }

    public static function validPost(array $fields)
    {
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
            http_response_code(200);
            echo 'OK';

        } catch (\Throwable $e) {
            http_response_code(400);
            echo $e->getMessage();
        }

    }
}