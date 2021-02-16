<?php


namespace Otushw;

class AppFactory
{

    /**
     * @return Base
     * @throws \Exception
     */
    public static function create(): Base
    {
        $type = self::getType();

        switch ($type) {
            case 'server':
                return new Server();
            case 'client':
                return new Client();
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getType(): string
    {
        $param = new Param();
        return $param->getParam();
    }
}