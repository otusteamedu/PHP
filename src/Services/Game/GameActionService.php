<?php


namespace Src\Services\Game;

use Src\DTO\ResetRowsDTO;
use Src\Entities\Play;
use Src\Http\Request;

class GameActionService
{
    public function getNext(Play $play, Request $request) : Play
    {
        $this->checkRowsReset($play, $request);
        $this->applyActions($play, $request);

        return $play;
    }

    private function applyActions(Play $play, Request $request) : void
    {
        $action = new (DEFAULT_ACTION)();

        $requestActions = $this->getRequestActions($request);

        foreach (ACTIONS as $actionName => $actionClass){
            if(in_array($actionName, $requestActions, true)){
                $action = new $actionClass($action);
            }
        }

        $action->apply($play);
    }

    private function getRequestActions(Request $request) : array
    {
        return explode(',', $request->getGet()['actions']);
    }

    private function checkRowsReset(Play $play, Request $request) : void
    {
        $resetRowsCount = $this->getRowsResetCount($request);

        if(!$resetRowsCount){
            return;
        }

        $this->resetRowsNotify(
            $play,
            $this->getRowsResetFrom($request),
            $resetRowsCount,
        );
    }

    private function getRowsResetCount(Request $request) : int
    {
        return $request->getGet()[RESET_ROWS_COUNT] ?? 0;
    }

    private function getRowsResetFrom(Request $request) : int
    {
        return $request->getGet()[RESET_ROWS_FROM] ?? 0;
    }

    private function resetRowsNotify(Play $play, int $fromRow, int $count) : void
    {
        $dispatchedEvent = $play->getEvents()[RESET_ROWS_EVENT] ?? null;

        if(is_null($dispatchedEvent)){
            return;
        }

        $dispatchedEvent->setPlay($play);
        $dispatchedEvent->setResetRowsDto(new ResetRowsDTO($fromRow, $count));
        $dispatchedEvent->notify();
    }
}