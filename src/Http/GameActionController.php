<?php


namespace Src\Http;

use Src\Services\Game\GameActionService;

class GameActionController
{
    public function index(Request $request) : string
    {
        $play =  $request->getSession()[SESSION_PLAY_KEY];

        $service = new GameActionService();
        $play = $service->getNext($play, $request);

        $request->getSession()[SESSION_PLAY_KEY] = $play;

        return json_encode($play, JSON_THROW_ON_ERROR);
    }
}