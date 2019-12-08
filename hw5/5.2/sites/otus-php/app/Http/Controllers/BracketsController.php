<?php

namespace App\Http\Controllers;

use App\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BracketsController extends Controller
{
    public function checkBrackets(
        Request $request,
        Validator $validator,
        Response $response
    )
    {
        $requestString = $request->get('string');

        if (!$validator->validateLength($requestString)) {
            $msg = "Количество переданных скобок должно быть больше {$validator->getMinLength()}";

            return new Response($msg, 400);
        }

        if (!$validator->validateCloseBrackets($requestString)) {
            $msg = "Нет открывающей скобки для закрывающей скобки расположенной на позиции {$validator->getCloseErrorPosition()}";

            return new Response($msg, 400);
        }

        if (!$validator->validateOpenBrackets($requestString)) {
            $msg = "Открывающая скобка уровня {$validator->getErrorLevel()}, открытая на позиции {$validator->getOpenErrorPosition()} не имеет закрывающей скобки на позиции {$validator->getCloseErrorPosition()}";

            return new Response($msg, 400);
        }

        return new Response('Скобки корректны', 200);
    }
}
