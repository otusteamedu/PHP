<?php

namespace Nlazarev\Hw6\Model\HTTP;

class HttpPost
{
    private $URL = null;
    private $http_request = array();
    private $http_response = array();
    private $http_request_context = null;

    public function __construct(array $request_postdata)
    {
        $this->http_request = array(
            'http' => 
                array(
                    'method'  => "POST", 
                    'header'  => "Content-type: application/x-www-form-urlencoded ",
                    'content' => http_build_query($request_postdata)
                )
            );

        $this->http_request_context = stream_context_create($this->http_request);
    }

    public function setPostContentValue(array $request_postdata)
    {
        $this->http_request['http']['content'] = http_build_query($request_postdata);
        $this->http_request_context = stream_context_create($this->http_request);
    }

    public function setPostHeaderValue(string $request_header)
    {
        $this->http_request['http']['header'] = $request_header;
        $this->http_request_context = stream_context_create($this->http_request);
    }

    public function getPostResult(string $URL): ?string
    {
        $this->URL = $URL;

        try {
            // When getting 400 code - warning here if not use @
            // Warning isn't Exeption
            $result = @file_get_contents($URL, false, $this->http_request_context);
            return $this->getHttpCode($http_response_header); //Magic     
        } catch (Exeption $e) {
            return "Caught exception: " . $e->getMessage() . "\n";
        }
    }

    protected function getHttpCode(array $http_response_header): int
    {
        $this->http_response = $http_response_header;

        if (is_array($http_response_header)) {
            $parts = explode(' ', $http_response_header[0]);
            if (count($parts) > 1) { 
                return intval($parts[1]);
            }
        }

        return 0;
    }

}