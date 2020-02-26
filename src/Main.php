<?php

namespace App;

use http\Client;
use http\Client\Request;
use http\Message\Body;
use http\QueryString;

class Main
{
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';

    public function run(): void
    {
        $url = 'http://otus-php-nginx/page.php';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        // curl --header "Content-Type: application/json" --request POST --data '{"username":"xyz","password":"xyz"}' http://otus-php-nginx/page.php

        $body = new Body();
        $body->addForm(
            [
                'field1' => 'value',
                'field2' => 'value2',
            ]
        );

        $request = new Request(self::METHOD_POST, $url, $headers);
//        $request->addBody($body);
        $request->getBody()->append(
            new QueryString(
                [
                    "user" => "mike",
                    "name" => "Michael Wallner"
                ]
            )
        );

        $client = new Client();
        $client->enqueue($request)->send();

//        $response = $client->getResponse($request);

        $response = $client->getResponse();

        printf(
            "%s returned '%s' (%d)\n",
            $response->getTransferInfo("effective_url"),
            $response->getInfo(),
            $response->getResponseCode()
        );

        echo '<br>' . $response->getBody();
    }
}
