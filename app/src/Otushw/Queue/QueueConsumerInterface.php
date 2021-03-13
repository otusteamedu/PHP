<?php


namespace Otushw\Queue;

interface QueueConsumerInterface extends QueueInstance
{
    public function consume(): void;
}