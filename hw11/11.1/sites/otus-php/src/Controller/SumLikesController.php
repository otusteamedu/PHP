<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use App\Services\Statistic;

class SumLikesController
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
        $channelUrl = $this->app->request->get('channel_url') ?: 'channel_1_url' ;
        $result = $this->stat->sumAllChannelLikes($channelUrl);

        return new Response($result);
    }
}



