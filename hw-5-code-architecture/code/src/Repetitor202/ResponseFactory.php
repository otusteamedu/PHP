<?php


namespace Repetitor202;


abstract class ResponseFactory
{
    abstract public function build(): IResponseService;
}