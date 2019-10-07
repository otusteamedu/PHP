<?php
declare(strict_types = 1);

namespace Alex\Deikstra;


class Graf
{
    public $nodes = array();

    public function __construct($filePath)
    {
        if (!is_file($filePath)) {
            throw new \Exception('File not found');
        }

        $fp = fopen($filePath, 'rb+');
        $json_str = '';
        $edges = [];
        if ($fp) {
            while(!feof($fp)) {
                $json_str .= fread($fp, 1024);
            }

            if (!empty($json_str)) {
                $edges = json_decode($json_str, true);
            }
            fclose($fp);

            if (empty($edges)) {
                throw new \Exception('Data for build graph not found');
            }

            //add edges
            foreach ($edges as $edge) {
                $this->addEdge((string) $edge[0], (string) $edge[1], $edge[2]);
            }
        }


    }

    public function addEdge(string $start, string $end, $weight = 0) {
        if (!isset($this->nodes[$start])) {
            $this->nodes[$start] = array();
        }
        $this->nodes[$start][] = new Edge($start, $end, $weight);
    }

    public function removeNode(int $index) {
        array_splice($this->nodes, $index, 1);
    }


    public function pathFrom(string $from)
    {

        $distances = [];

        $distances[$from] = 0;

        $visited = [];

        $previous = [];

        $calcList = new CalcList();

        $calcList->add([$distances[$from], $from]);

        $nodes = $this->nodes;

        while($calcList->getSize() > 0) {

            list(,$i) = $calcList->remove();

            if (isset($visited[$i])) {
                continue;
            }

            $visited[$i] = true;

            if (!isset($nodes[$i])) {
                continue;
            }

            foreach($nodes[$i] as $edge) {
                $alt = $distances[$i] + $edge->weight;
                $end = $edge->end;
                if (!isset($distances[$end]) || $alt < $distances[$end]) {
                    $previous[$end] = $i;
                    $distances[$end] = $alt;
                    $calcList->add(array($distances[$end], $end));
                }
            }
        }
        return array($distances, $previous);
    }

    public function pathTo(array $nodeDistances, string $toNode)
    {
        $path = [];

        if (isset($nodeDistances[$toNode])) { // only add if there is a path to node
            $path[] = $toNode;
        }

        while(isset($nodeDistances[$toNode])) {
            $nextNode = $nodeDistances[$toNode];

            $path[] = $nextNode;

            $toNode = $nextNode;
        }

        return array_reverse($path);

    }

    public function getPath(string $fromNode, string $toNode)
    {
        list($distances, $prevEdge) = $this->pathFrom($fromNode);

        $path = $this->pathTo($prevEdge, $toNode);

        $cost = $distances[$toNode];

        return implode('->', $path) . ' cost: ' . $cost;
    }

    public function getDistances(string $from)
    {
        list($distances) = $this->pathFrom($from);

        $distances_txt = '';

        foreach ($distances as $node => $distance) {
            if (!$distance) {
                continue;
            }
            $distances_txt .= 'from node ' . $from . ' to node ' . $node . ' distance = ' . $distance . '<br>';
        }

        return $distances_txt;
    }
}