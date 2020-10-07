<?php

namespace Otus\Http;

use JsonException;

class JsonResponse implements ResponseContract
{
    private Response $response;

    public function __construct(int $code = 200, $content = null)
    {
        switch ($code) {
            case Response::HTTP_BAD_REQUEST:
                $data = [
                    'message' => 'There are errors in your data',
                    'errors'  => $content,
                ];
                break;
            case Response::HTTP_INTERNAL_SERVER_ERROR:
                $data = [
                    'message' => 'Internal server error',
                    'errors'  => $content,
                ];
                break;
            case Response::HTTP_NOT_FOUND:
                $data = [
                    'message' => 'Not found',
                ];
                break;
            case Response::HTTP_OK:
            default:
                $data = $content;
                break;
        }

        try {
            $data = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            $code    = Response::HTTP_INTERNAL_SERVER_ERROR;
            $data = $exception->getMessage();
        }

        $this->response = new Response($code, $data);
        $this->response->header('Content-Type', 'application/json');
    }

    public function send(): void
    {
        $this->response->send();
    }
}