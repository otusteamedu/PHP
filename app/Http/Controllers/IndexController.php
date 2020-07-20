<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Validators\StringValidatorInterface;
use App\Validators\RoundBracketsValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @var StringValidatorInterface
     */
    private $bracketsValidator;

    public function __construct()
    {
        $this->bracketsValidator = new RoundBracketsValidator();
    }

    public function index(Request $request): Response
    {
        if (!empty($request->post('string'))
            && $this->bracketsValidator->validate($request->post('string'))
        ) {
            return new Response('Your string is success', Response::HTTP_OK);
        } else {
            return new Response('Your string is error', Response::HTTP_BAD_REQUEST);
        }
    }
}
