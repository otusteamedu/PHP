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
			foreach ($result as $toKey => $data) {
                if ($data['weight'] !== INF) {
                    echo "Shortest path from '$from' to '$toKey' is: " . implode('->', array_merge($data['path'], [$toKey])) . '. It cost: ' . $data['weight'] . PHP_EOL;
                } else {
                    echo "Path from '$from' to '$toKey' is unreachable. . It cost: " . $data['weight'] . PHP_EOL;
                }
            }
    ?>
    
More Examples in Example folder
