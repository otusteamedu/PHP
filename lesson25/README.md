# Dijkstra graph exploree

###How usage
clone or download, then `$ composer install`

    <?php
       require '../vendor/autoload.php';

		use Otus\Graph;

		$routes = file_get_contents('Dijkstra.json');
		try {
			$from = 1;
			$to = 11;
			$graph = Graph::getGraphByRoutes(json_decode($routes));
			$result = $graph->getDijkstraRoute($from, $to);
			// Shortest path from '1' to '11' is: 1->2->5->6->9->10->11. It cost: 38
			echo "Shortest path from '$from' to '$to' is: " . implode('->', $result['path']) . '. It cost: ' . $result['weight'] . PHP_EOL;
    ?>
    
More Examples in Example folder
