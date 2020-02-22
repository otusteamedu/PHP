<?php

namespace Sergey\Otus;

class App
{
	public function run()
	{
		$this->controller = $this->getController();
		$this->controller->execute();
	}

	protected function getController()
	{
		return new \Sergey\Otus\Controller\Math();
	}
}
