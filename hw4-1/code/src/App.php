<?php
declare(strict_types=1);

namespace App;

use App\Http\Exception\HttpException;
use App\Http\Response;
use App\Validator\Rule\Brackets;
use App\Validator\Rule\NotBlank;
use App\Validator\ValidatorFactory;

/**
 * Class App
 */
final class App
{
    /**
     * @return Response
     */
    public function run(): Response
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate(
            $_POST['string'] ?? null,
            [
                new NotBlank('String should not be blank'),
                new Brackets(),
            ],
        );

        if ($errors) {
            throw new HttpException(400, $errors[0]->message);
        }

        return new Response('OK');
    }
}
