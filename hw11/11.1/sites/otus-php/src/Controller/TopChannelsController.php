<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use App\Services\Statistic;

class TopChannelsController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var Statistic
     */
    private $stat;

    public function __construct(Application $app)
    {
        $this->stat = new Statistic($app->getDb());
        $this->app = $app;
    }

    public function handler()
    {
        $limit = intval($this->app->request->get('limit'));
        $limit = $limit > 0 ? $limit : 0 ;
        $result = $this->stat->topRateChannels($limit);

        return new Response($result);
    }
}



