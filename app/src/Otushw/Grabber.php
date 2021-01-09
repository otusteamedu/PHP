<?php


namespace Otushw;

use Otushw\DBSystem\NoSQLDAO;

class Grabber implements Application
{
    public function __construct(NoSQLDAO $db)
    {
        $videoMapper = new VideoMapper($db);
        $youtube = new Youtube();
        $i = 0;
        while (true) {
            $youtube->getListVideosID();
            if (empty($youtube->getNumberListVideo())) {
                break;
            }
            while ($videoSource = $youtube->getVideo()) {
                if ($videoMapper->insert($videoSource)) {
                    $i++;
                }
            }
        }
        View::showGrabber($i);
    }

}