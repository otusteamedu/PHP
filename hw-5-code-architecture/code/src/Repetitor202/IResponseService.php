<?php


namespace Repetitor202;


interface IResponseService
{
    public function successOutput(): void;

    public function failedOutput(string $error): void;
}