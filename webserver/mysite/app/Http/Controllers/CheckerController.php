<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Sanerrus\Checker\Checker;
use Sanerrus\Exceptions\BadResultException;

class CheckerController extends Controller
{
    public function check(string $type, Request $request): JsonResponse
    {
        $strategy = new Checker();
        $checker = null;
        try {
            $checker = $strategy->getChecker($type);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error'=>$e->getMessage()], Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }
        if($checker === null) {
            return response()->json(['error'=>'Что то пошло не так'], Response::HTTP_METHOD_NOT_ALLOWED, [], JSON_UNESCAPED_UNICODE);
        }

        try {
            $checker->check((string)$request->input('string'));
        } catch (BadResultException | \LengthException $e) {
            return response()->json(['error'=>$e->getMessage()], Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json(['message'=>'Текст прошел валидацию'], Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
