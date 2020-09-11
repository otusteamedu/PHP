<?php

namespace Otus\Http;

use Chelout\EmailValidator\EmailValidator;
use Chelout\EmailValidator\Rules\MxRule;
use Chelout\EmailValidator\Rules\RegexpRule;
use Throwable;

class Controller
{
    private EmailValidator $validator;

    public function __construct()
    {
        try {
            $this->validator = new EmailValidator([
                new RegexpRule(),
                new MxRule(),
            ]);
        } catch (Throwable $throwable) {
            echo $throwable->getMessage();
        }
    }

    public function index(Request $request): ResponseContract
    {
        foreach ($request->data('emails') as $email) {
            $this->validator->validate($email);
        }

        if ($this->validator->hasErrors()) {
            return new JsonResponse(Response::HTTP_BAD_REQUEST, $this->validator->getErrors());
        }

        return new JsonResponse(Response::HTTP_OK, 'OK');
    }
}
