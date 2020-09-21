<?php

namespace Controllers;

use Exceptions\RestClientException;

class MainController extends Controller
{
    protected $es;

    public function __construct()
    {
        $this->es = new ElasticSearchController();
    }

    /**
     * @throws RestClientException
     */
    public function generate()
    {
        $this->render('MainView.php');

        if (isset($_GET['show'])) {
            $arrResult = $this->getSaveYoutubeData()['hits']['hits'];
            foreach ($arrResult as $result) {
                $this->render('StatisticsView.php', $result);
            }
        }

        if (isset($_GET['name']) && iconv_strlen($_GET['name']) < 150) {
            $name = htmlspecialchars($_GET['name']);
            $this->writeYoutubeData($name);
        } elseif (isset($_GET['name'])) {
            $this->render('WrongUserInputView.php');
        }
    }

    public function getSaveYoutubeData()
    {
        return $this->es->searchDocument([
            'index' => 'youtube'
        ]);
    }

    /**
     * @param string $name - имя канала
     * @return bool
     * @throws RestClientException
     */
    public function writeYoutubeData(string $name)
    {
        $youtubeChannelModel = (new YouTubeAPIController())->getData($name);
        if ($youtubeChannelModel !== false) {
            $youtubeChannelModel->save();
            return true;
        }
        return false;
    }
}
