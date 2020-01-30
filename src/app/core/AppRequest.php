<?php

namespace Core;

class AppRequest
{
    private string $requestStr = "";

    /**
     * AppRequest constructor.
     * @param string|null $requestStr
     */
    public function __construct(?string $requestStr = null)
    {
        $this->build($requestStr);
    }

    /**
     * @return string
     */
    public function getRequestStr(): string
    {
        return $this->requestStr;
    }

    /**
     * @param string $requestStr
     */
    public function setRequestStr(string $requestStr): void
    {
        $this->requestStr = $requestStr;
    }

    /**
     * @param string|null $reqStr
     */
    private function build(?string $reqStr = null)
    {
        $this->requestStr = str_replace("?" . $_SERVER["QUERY_STRING"] ?? "", "", $reqStr ?? ($_SERVER["REQUEST_URI"] ?? "") ?? "/");
    }
}