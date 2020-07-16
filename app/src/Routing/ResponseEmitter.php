<?php

namespace App\Routing;

use App\Interfaces\ResponseInterface;

class ResponseEmitter
{
    /**
     * @param ResponseInterface $response
     */
    public function emit(ResponseInterface $response): void {
        if (headers_sent() === false) {
            $this->emitStatusLine($response);
        }
            $this->emitBody($response);
    }

    /**
     * @param ResponseInterface $response
     */
    private function emitStatusLine(ResponseInterface $response): void {
        $statusLine = sprintf(
            'HTTP/%s %s %s',
            $response->getVersion(),
            $response->getStatusCode(),
            ''
        );
        header($statusLine, true, $response->getStatusCode());
    }

    /**
     * @param ResponseInterface $response
     */
    private function emitBody(ResponseInterface $response): void {
        $content = $response->getContent();
        $content = json_encode($content);

        echo $content;
    }
}