<?php

namespace HW7_1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PSR7Body extends PSR7Base
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $content = '';
        while ($str = $request->getBody()->read(1024)) {
            $content .= $str;
        }
        $emails = explode("\n", $content);
        $result = $this->validation->validateArray($emails);
        return $this->createResponse($response, $result);
    }
}
