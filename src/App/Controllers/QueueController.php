<?php

namespace Ozycast\App\Controllers;

use Ozycast\App\Core\Controller;
use Ozycast\App\Models\Queue\QueueOrders;

class QueueController extends Controller
{
    public static $auth = false;

    /**
     * Добавить нового обработчика очереди обработки заказа
     */
    public function actionConsumer()
    {
        QueueOrders::addConsumer();
    }

}
