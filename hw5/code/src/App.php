<?php
declare(strict_types=1);

namespace App;

use App\Http\Exception\HttpException;
use App\Http\JsonResponse;
use App\Validator\Rule\NotBlank;
use App\Validator\Rule\Email;
use App\Validator\ValidatorFactory;

/**
 * Class App
 */
final class App
{
    /**
     * @return JsonResponse
     */
    public function run(): JsonResponse
    {
        $emails = $_POST['emails'] ?? [];

        if (empty($emails) || !is_array($emails)) {
            throw new HttpException(400, 'Emails are required');
        }

        $validator = ValidatorFactory::create();

        $validEmails = [];

        foreach ($emails as $email) {
            $errors = $validator->validate(
                $email,
                [new NotBlank(), new Email()],
            );

            if (!$errors) {
                $validEmails[] = $email;
            }
        }

        return new JsonResponse($validEmails);
    }
}
