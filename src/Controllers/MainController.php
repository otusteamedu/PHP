<?php

namespace Controllers;

use Exceptions\RestClientException;
use Model\UserInputModel;
use View\MainView;
use View\StatisticView;

class MainController extends Controller
{
    protected $es;

    public function __construct()
    {
        $this->es = new ElasticSearchController();
        $this->view = new MainView($this);
    }

    public function generate()
    {
        $this->view->output();

        if (isset($_GET['show'])) {
            $statView = new StatisticView($this);
            $statView->output();
        }

        if (isset($_GET['name'])) {
            new UserInputModel($this, $_GET['name']);
        }
    }

    public function getSaveYoutubeData()
    {
        return $this->es->searchDocument([
            'index' => 'youtube'
        ]);
    }

    /**
     * @param string $nameChannel
     * @return bool
     * @throws RestClientException
     */
    public function writeYoutubeData(string $nameChannel)
    {
        $youtubeChannelModel = (new YouTubeAPIController())->getData($nameChannel);
        if ($youtubeChannelModel !== false) {
            $youtubeChannelModel->save();
            return true;
        }
        return false;
    }
}
