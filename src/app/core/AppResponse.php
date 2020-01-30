<?php

namespace Core;

class AppResponse
{
    public const CONTENT_TYPE_HTML = "text/html";
    public const CONTENT_TYPE_JSON = "application/json";

    private int $code = 200;
    private string $contentType = self::CONTENT_TYPE_HTML;

    private string $content = "";

    /**
     * AppResponse constructor.
     * @param string|null $content
     * @param int|null    $code
     */
    public function __construct(string $content = "", int $code = 200)
    {
        $this->content = $content ?? "";
        $this->code = $code ?? "";
    }

    /**
     * @param int|null $code
     */
    public function flush(int $code = 200): void
    {
        if (!headers_sent()) {
            header("HTTP/1.1 " . ($code ?? $this->code));
            header("Content-Type: {$this->contentType}; charset=utf-8");
        }
        echo $this->content;
    }

    /**
     * @param string $content
     * @return AppResponse
     */
    public function setContent(string $content): AppResponse
    {
        $this->content .= $content ?? "";
        return $this;
    }

    /**
     * @param string $contentType
     * @return AppResponse
     */
    public function setContentType(string $contentType): AppResponse
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return AppResponse
     */
    public function setCode(int $code): AppResponse
    {
        $this->code = $code;
        return $this;
    }
}