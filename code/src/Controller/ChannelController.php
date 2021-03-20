<?php


namespace App\Controller;



use App\Services\YouTubeChannels;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ChannelController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        $result = 'Channel';

        $query = htmlspecialchars($request->getAttribute('q'));


        $service = $this->container->get(YouTubeChannels::class);
        $channels = $service->search($query)->getItems();


        return $this->render($response, 'channel/index.php', [
            'result' => $result,
            'data' => $channels,
        ]);
    }

}
