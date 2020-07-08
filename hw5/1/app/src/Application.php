<?php

namespace Application;

use BracketValidator\BracketValidator;
use BracketValidator\ErrorFormatter;
use BracketValidator\Validator\Even;
use BracketValidator\Validator\Length;
use BracketValidator\Validator\Pairs;
use BracketValidator\Validator\UnwantedSymbol;
use SebastianBergmann\Template\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    const FORM_PARAM_NAME = 'form';
    const STRING_PARAM_NAME = 'string';
    const SUCCESS_MESSAGE = 'Ok';

    const TEMPLATE_DIR = __DIR__ . '/../templates/';

    private Template $templater;

    public function __construct()
    {
        $this->templater = new Template(self::TEMPLATE_DIR . 'form.tpl');
    }

    public function run(Request $request): Response
    {
        if ($request->query->has(self::FORM_PARAM_NAME)) {
            $this->templater->setVar(
                [
                    'allowedSymbols' => BracketValidator::ALLOWED_SYMBOLS,
                    'paramName' => self::STRING_PARAM_NAME
                ]
            );
            return new Response($this->templater->render(), Response::HTTP_OK);
        }

        $errors = (new BracketValidator)
            ->addValidator(new Length)
            ->addValidator(new UnwantedSymbol)
            ->addValidator(new Even)
            ->addValidator(new Pairs)
            ->run($request->request->get(self::STRING_PARAM_NAME));

        if (empty($errors)) {
            return new Response(self::SUCCESS_MESSAGE, Response::HTTP_OK);
        }

        return new Response(
            ErrorFormatter::get($errors, "# %s<br>"),
            Response::HTTP_BAD_REQUEST
        );
    }
}