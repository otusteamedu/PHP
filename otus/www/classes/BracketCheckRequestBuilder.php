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
            $this->string = null;
        }
        return $this;
    }

    public function build()
    {
        return BracketCheckRequest::build($this);
    }

    public function getString()
    {
        return $this->string;
    }
}
