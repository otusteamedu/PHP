<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Validators\StringValidatorInterface;
use App\Validators\RoundBracketsValidator;
use Illuminate\Http\Request;

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

    public function index(Request $request): string
    {
        if (!empty($request->post('string'))
            && $this->bracketsValidator->validate($request->post('string'))
        ) {
            http_response_code(200);
            return 'Your string is success';
        } else {
            http_response_code(400);
            return 'Your string is error';
        }
    }
}
