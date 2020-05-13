<?php

namespace Classes;

class BracketCheckRequestBuilder
{
    private $string;

    public function setString(array $postData)
    {
        if (array_key_exists('string', $postData)) {
            $this->string = $postData['string'];
        } else {
            $this->string = '';
        }
        return $this;
    }

    public function build(): BracketCheckRequest
    {
        return BracketCheckRequest::build($this);
    }

    public function getString()
    {
        return $this->string;
    }
}
