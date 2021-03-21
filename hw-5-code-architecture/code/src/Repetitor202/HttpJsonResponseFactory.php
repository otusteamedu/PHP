<?php


namespace Repetitor202;


class HttpJsonResponseFactory extends ResponseFactory
{

    public function build(): IResponseService
    {
        return new HttpJsonResponseService();
    }
}