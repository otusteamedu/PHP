<?php

namespace Sergey\Otus\Controller;

class Math
{

	public function execute()
	{
		$model = new \Sergey\Otus\Model\Calculator();
		$view = new \Sergey\Otus\View\Calculator();
		$view->display($model); 
	}
}
