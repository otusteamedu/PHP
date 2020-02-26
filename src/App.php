<?php

namespace Sergey\Otus;

use Sergey\Otus\Helper\ConfigProvider;

class App
{
    private $controller;

	public function run()
	{
	    try {
            ConfigProvider::getInstance(__DIR__);
            $this->controller = $this->getController();
            $this->controller->execute();
        } catch (\Exception $e) {
	        echo 'Error: ' . $e->getMessage(); exit;
        }
	}

	protected function getController()
	{
        $options = getopt("r:");

        if (!empty($options['r'])) {

            if ($options['r'] == 'server') {
                return new \Sergey\Otus\Controller\Server();
            }

            if ($options['r'] == 'client') {
                return new \Sergey\Otus\Controller\Client();
            }
        }

	    throw new \Exception('Invalid Param');
	}
}
