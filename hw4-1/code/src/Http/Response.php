<?php
declare(strict_types=1);

namespace App\Http;

/**
 * Class Response
 */
class Response
{
    /**
     * @param string|null $content
     * @param int         $statusCode
     */
    public function __construct(
        private ?string $content = '',
        private int $statusCode  = 200,
    ) {
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        echo $this->content;
    }
}
