<?php


namespace Classes\Queue;


interface BrockerInterface
{

    public function pushRequest(string $request);

    public function popResponse(string $id);

    public function pushResponse(string $response);

    public function popRequest(): string ;
}
