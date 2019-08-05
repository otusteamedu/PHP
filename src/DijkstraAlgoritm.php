<?php
namespace Paa\App;

class DijkstraAlgoritm {

    private $INT_MAX = 99999;

    public function minimumDistance($distance, $shortestPathTreeSet, $verticesCount)
    {
	$min = $this->INT_MAX;
	$minIndex = 0;
    
	for ($v = 0; $v < $verticesCount; ++$v)
	{
	    if ($shortestPathTreeSet[$v] == false && $distance[$v] <= $min)
	    {
    		$min = $distance[$v];
		$minIndex = $v;
	    }
	}
	return $minIndex;
    }

    public function calcAlgoritm($graph, $source, $verticesCount)
    {
	$distance = array();
	$shortestPathTreeSet = array();
					
	for ($i = 0; $i < $verticesCount; ++$i)
	{
    	    $distance[$i] = $this->INT_MAX;
	    $shortestPathTreeSet[$i] = false;
	}
													    
	$distance[$source] = 0;
		
	for ($count = 0; $count < $verticesCount - 1; ++$count)
	{
	    $u = $this->minimumDistance($distance, $shortestPathTreeSet, $verticesCount);
	    $shortestPathTreeSet[$u] = true;
	    for ($v = 0; $v < $verticesCount; ++$v)
		if (!$shortestPathTreeSet[$v] && @$graph[$u][$v] && $distance[$u] != $this->INT_MAX && $distance[$u] + $graph[$u][$v] < $distance[$v]) {
		    $distance[$v] = $distance[$u] + $graph[$u][$v];
		}
    	    }
	    $this->showPath($distance, $verticesCount);
    }

    public function showPath($distance, $verticesCount)
    {
        echo "Вершина    Расстояние от источника" . PHP_EOL;
        echo "----------------------------------" . PHP_EOL;
        for ($i = 0; $i < $verticesCount; ++$i) {
	    echo $i . "\t  " . $distance[$i] . PHP_EOL;
	}
    }
																									    
}

