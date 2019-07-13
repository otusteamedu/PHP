<?php

namespace crazydope\youtube\db;

use crazydope\youtube\ChannelInterface;

interface GetChannelInterface
{
    public function getChannelById(string $id): ?ChannelInterface;
}