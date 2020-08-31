<?php

namespace Nlazarev\Hw6\Model\Email;

use Nlazarev\Hw6\Model\HTTP\HttpPost;

class EmailString
{
    private $value = null;
    private $is_valid = null;

    public function __construct(string $email_value = null)
    {
        $this->value = $email_value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function isValid(): ?bool
    {
        return $this->is_valid;
    }

    public function validateOverPOSTRequest(string $URL)
    {
        $request_postdata = array(
           'email' => $this->getValue()
        );

        $http_post = new HttpPost($request_postdata);

        switch ($http_post->getPostResult($URL)) {
            case "200":
                $this->is_valid = true;
                break;
            case "400":
                $this->is_valid = false;
                break;
        }
    }
}