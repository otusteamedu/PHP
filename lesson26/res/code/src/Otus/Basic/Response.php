<?php


namespace Otus\Basic;


/**
 * Class Response
 * @package Otus\Basic
 */
class Response
{
    /**
     * Bad API response code
     */
    const API_BAD_RESPONSE = 400;
    /**
     * Good API response code
     */
    const API_OK_RESPONSE = 200;

    /**
     * @var
     */
    private $content;
    /**
     * @var int
     */
    private $status_code;
    /**
     * @var array
     */
    private $headers;

    /**
     * Response constructor.
     * @param string $content
     * @param int $status_code
     * @param array $headers
     */
    public function __construct($content = '', $status_code = 200, $headers = array())
    {
        $this->content = $content;
        $this->status_code = $status_code;
        $this->headers = $headers;
    }

    /**
     * @param $status_code
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
    }

    /**
     * @param $header
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }

    /**
     *
     */
    public function send()
    {
        header('HTTP/1.1 ' . $this->status_code);
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param $content
     * @param $code
     */
    public function sendErrorApiResponse($content, $code)
    {
        $this->setHeader('Content-Type: application/json');
        $this->setContent(json_encode(['error' => $content, 'code' => $code]));
        $this->setStatusCode(self::API_BAD_RESPONSE);
        $this->send();
        exit();
    }

    /**
     * @param $content
     */
    public function sendApiResponse($content)
    {
        $this->setHeader('Content-Type: application/json');
        $this->setContent(json_encode(['message' => $content]));
        $this->setStatusCode(self::API_OK_RESPONSE);
        $this->send();
        exit();
    }
}