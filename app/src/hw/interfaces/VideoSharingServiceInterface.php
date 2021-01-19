<?php

namespace VideoPlatform\interfaces;

interface VideoSharingServiceInterface
{
    public function analyze();
    public function getStatistics();
    public function getTopChannels();
}