<?php

namespace crazydope\theater\Handlers;

use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;

class CustomExceptionHandler implements IExceptionHandler
{
    /**
     * @param Request $request
     * @param \Exception $error
     * @throws \Exception
     */
    public function handleError(Request $request, \Exception $error): void
    {
        if ($request->getUrl()->contains('/api')) {
            response()->httpCode($error->getCode())->json([
                'status'=>'error',
                'message' => $error->getMessage(),
                'code'  => $error->getCode(),
            ]);
        }
        /* The router will throw the NotFoundHttpException on 404 */
        if($error instanceof NotFoundHttpException) {
            $request->setRewriteCallback('Controllers\DefaultController@notFound');
            return;
        }
        throw $error;
    }
}