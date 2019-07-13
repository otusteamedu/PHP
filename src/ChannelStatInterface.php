<?php

namespace crazydope\youtube;

interface ChannelStatInterface
{
    public function getTitle(): string;

    public function getLikes(): int;

    public function getDisLikes(): int;

    public function getRate();

    public function __toString();
}