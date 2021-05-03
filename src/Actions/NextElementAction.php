<?php


namespace Src\Actions;


use Src\Entities\Play;
use Src\Services\Element\NextElementService;

class NextElementAction extends BasePlayAction
{
    public function apply(Play $play): void
    {
        $nextElementService = new NextElementService();
        $nextElement = $nextElementService->get();

        //новый элемент добавляем посередине сверху.
        $nextElement->setPlacementRow($play->getPlayGround()->getRows());
        $nextElement->setPlacementRow(ceil($play->getPlayGround()->getCols() / 2));

        $nextElement->setSpeed($play->getCurrentLevel()->getSpeed());

        $play->setCurrentElement($nextElement);

        parent::apply($play);
    }
}