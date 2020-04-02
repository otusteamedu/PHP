<?php
namespace Otus\HW11\Task1;

use \Otus\HW11\Task1;

interface IStorage
{
    public function init();

    public function showStatus();

    public function addChannel(Task1\Channel $chanel);

    public function addVideo(Task1\Video $video);

    public function deleteChannel(Task1\Channel $chanel);

    public function deleteVideo(Task1\Video $video);

}
