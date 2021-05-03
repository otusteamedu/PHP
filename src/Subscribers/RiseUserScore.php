<?php


namespace Src\Subscribers;


use Src\Events\Event;
use Src\Services\Score\ScoreService;

class RiseUserScore implements Subscriber
{
    public function handle(Event $event): void
    {
        $play = $event->getPlay();
        $resetRowsDto = $event->getResetRowsDto();

        $userScore = $play->getUser()->getScore();

        $scoreService = new ScoreService();
        $scoreCalculator = SCORE_CALCULATORS_BY_ROWS[$resetRowsDto->getCount()];
        $scoreService->setCalculator(new $scoreCalculator);

        $userScore +=  $scoreService->calculate($play);

        $play->getUser()->setScore($userScore);
    }
}