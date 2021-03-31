<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AirlineController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        $airlines = $this->modelManager
            ->getRepository('Airline')
            ->findAll();

        return $this->render($response, 'airline/index.php', [
            'airlines' => $airlines,
        ]);
    }

    public function show(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $airline = $this->modelManager
            ->getRepository('Airline')
            ->findOne($id);

        return $this->render($response, 'airline/show.php', [
            'airline' => $airline,
        ]);
    }

}
