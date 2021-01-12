<?php


namespace Otushw;

class Grabber
{
    public function __construct(StorageInterface $storage)
    {
        $videoMapper = new VideoMapper($storage);
        $youtube = new Youtube();
        $i = 0;
        $j = 0;
        while($j < 1) {
            $j++;
//        while (true) {
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