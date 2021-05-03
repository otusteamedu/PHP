<?php


namespace Src;


use Src\Http\GameActionController;
use Src\Http\GameController;
use Src\Http\Request;

class App
{
    public function run() : string
    {
        $request = new Request($_GET, $_SERVER, $_SESSION);

        if($request->isAjax()){
            $controller = new GameActionController();
        } else {
            $controller = new GameController();
        }

        return $controller->index($request);
    }
}