<?php


namespace Src\Http;


use Src\Services\Game\GameInitService;

class GameController
{
    public function index(Request $request) : string
    {
        $service = new GameInitService();
        $play = $service->start();

        $request->getSession()[SESSION_PLAY_KEY] = $play;

        return json_encode($play, JSON_THROW_ON_ERROR);
    }
}