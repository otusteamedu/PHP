<?php

namespace App\Controller;

use App\Validator\EmailValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        $result = '';

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $email = $data['email'];

            $validator = new EmailValidator();
            $status = $validator->validate($email);

            $result = sprintf(
                '"%s" - %s',
                $email,
                $status ? 'good email' : $validator->getError()
            );
        }

        return $this->render($response, 'home/index.php', [
            'name' => $_SERVER['SERVER_NAME'],
            'addr' => $_SERVER['SERVER_ADDR'],
            'result' => $result,
            ]);
    }
}
