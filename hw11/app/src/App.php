<?php


namespace HW;


class App
{
    private $listApp = [
        'youtube' => \Youtube\App::class,
        'redis' => \SysEvents\App::class
    ];

    public function run()
    {
        $app = $this->getRequestedApp();
        if (!$app)
            $this->outputError();
        else
            $app->run();
    }

    private function outputError()
    {
        http_response_code(400);
        echo "Unknown application name";
    }

    /**
     * @return AppInterface|null
     */
    private function getRequestedApp()
    {
        $appName = $this->listApp[$this->getAppID()] ?? '';
        if (empty($appName))
            return null;
        return new $appName();
    }

    private function getAppID()
    {
        return $_REQUEST['app'] ?? '';
    }



}