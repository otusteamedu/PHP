<?php
// app/Controller/HelloController.php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment as Render;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CheckResultController
{

    /**
     * @var Render
     */
    private $render;

    public function __construct(Render $render)
    {
        $this->render = $render;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response)
    {

        $email = htmlspecialchars($request->getParsedBody()['email']);
        $obCheck = new \WebFarrock\EmailChecker\Check();
        $obCheck->addChecker(new \WebFarrock\EmailChecker\RuleMxRecord());
        $result = $obCheck->check($email);

        if ($result->isSuccess()) {
            $message = 'Email успешно прошел проверку';
        } else {
            $message = 'Email не прошел проверку. '.join('. ', $result->getErrorMessages());
        }

        $response->getBody()->write(
            $this->render->render('check.twig', [
                'message' => $message,
                'email' => $email,
            ])
        );
        return $response;
    }


}