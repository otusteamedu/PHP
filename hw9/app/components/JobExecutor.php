<?php

namespace app\components;

class JobExecutor
{
    public function someWork(){

        $sleepTime = random_int(2, 60);
        sleep($sleepTime); // имитация сложного процесса

    }
}