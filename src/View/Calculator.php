<?php

namespace Sergey\Otus\View;

class Calculator
{
	public function display($calculator)
	{
		echo $calculator->sum(5, 10);
	}
}
