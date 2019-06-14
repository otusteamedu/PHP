<?php
namespace Calc;

class Calculate {

    private $strategy;

    public function __construct(StrategyInterface $strategy)
    {
	$this->strategy = $strategy;
    }

    public function setStrategy(StrategyInterface $strategy): void
    {
	$this->strategy = $strategy;
    }

    public function execute(float $a, float $b): float
    {
	return $this->strategy->calc($a, $b);
    }

}
