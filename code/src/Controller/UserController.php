<?php


namespace App\Controller;


use App\Message\BankOperationMessage;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends AbstractController
{
    public function bankAccount(Request $request, Response $response): Response
    {
        $email = $this->user->getEmail();

        $bankStatement = new BankOperationMessage($email, new DateTime('2021-05-25'), new DateTime());
        $this->messageService->push($bankStatement);


        return $this->render($response, 'user/bank.php', [
            'data' => null,
        ]);
    }

}
