<?php


namespace Otushw\Queue;

interface QueueInstance
{
    public function run(): void;
}
