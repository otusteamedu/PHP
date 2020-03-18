<?php

namespace Tirei01\Hw15;

class Dijkstra
{
    private int $start;
    private int $finish;
    private Graph $graph;
    private array $search;
    private DijkstraElement $current;

    public function __construct($start, $finish, Graph $graph)
    {
        $this->start = $start;
        $this->finish = $finish;
        $this->graph = $graph;
        $this->search = array();
    }

    public function forDebug(){
        /** @var DijkstraElement $search */
        foreach ($this->search as $search) {
            // TODO DEL THIS
            echo "<pre style='color:red; clear: both;'>";
            $back = '-';
            if ($search->getBackVertex() !== null) {
                $back = $search->getBackVertex()->getNumber();
            }
            var_dump(array(
                'V' => $search->getVertex()->getNumber(),
                'L' => $search->getLengthPath(),
                'Q' => $back
            ));
            echo "</pre>";
        }
    }

    private function add(DijkstraElement $vertex){
        $isset = false;
        /** @var DijkstraElement $search */
        foreach ($this->search as $search) {
            if($search->getVertex()->getNumber() === $vertex->getVertex()->getNumber()){
                $isset = true;
            }
        }
        if ($isset === false) {
            $this->search[] = $vertex;
        }

    }

    private function start(){
        $startVertex = $this->graph->getVertexByNum($this->start);
        $this->current = new DijkstraElement($startVertex, true, 0, null);
        $this->add($this->current);
    }

    public function find() : void {
        $this->start();

        $isFind = false;
        $i = 0;
        while ($isFind === false){
            $arVertexLink = $this->current->getVertex()->getLink();
            $arSteps = array();
            /** @var VertexLink $vartexLink */
            foreach ($arVertexLink as $vartexLink) {
                $arSteps[] = new DijkstraElement($vartexLink->getVertex(), false, $vartexLink->getWeigth(), $this->current->getVertex());
                //$this->add($tmpDijElem);
            }
            $i++;
            if($i >100 ){
                //# TODO DEL THIS
                echo "<pre style='color:red; clear: both;'>";
                print_r($i);
                echo "</pre>";
                break;
            }
        }

$this->forDebug();
        return;
        $isFind = false;
        $i = 0;
        $arIterators = array();
        $arIdVertWight = array();
        $coutV = $this->graph->getVertexNumbers();
        $lastConst = 0;
        //exit;
        while ($isFind === false){
            if(empty($arIterators)){
                foreach ($coutV as $vId) {
                    $l = null;
                    $q = '';
                    $c = false;
                    if($this->start === $vId) {
                        $l = 0;
                        $q = '';
                        $c = true;
                        $lastConst = $vId;
                        $arIdVertWight[$vId] = $l;
                    }
                    $arIterators[$i][] = array(
                        'V' => $vId,
                        'L' => $l,
                        'Q' => $q,
                        'CONST' => $c,
                    );
                }
            }else {
                // TODO DEL THIS
                echo "<pre style='color:#1917ff; clear: both;'>";
                var_dump(array(
                    'LAST_CONST' => $lastConst,
                    'BACK' => $i - 1,
                ));
                echo "</pre>";
                $verFintds = $this->graph->getVertexByNum($lastConst)->getLink();
                // TODO DEL THIS
                echo "<pre style='color:red; clear: both;'>";
                print_r($verFintds);
                echo "</pre>";
                $arMinWight = array();
                foreach ($arIterators[$i - 1] as $item) {
                    /** @var VertexLink $verFintd */
                    foreach ($verFintds as $verFintd) {

                        if( $item['V'] === $verFintd->getTo() && $item['CONST'] !== true) {

                            $distanceTraveled = 0;
                            if($arIdVertWight[$verFintd->getForm()]){
                                $distanceTraveled = $arIdVertWight[$verFintd->getForm()];
                            }
                            // TODO DEL THIS
                            echo "<pre style='color:#ff42b1; clear: both;'>";
                            var_dump($item['V'],$item['L'], ($distanceTraveled + $verFintd->getForm()));
                            echo "</pre>";
                            echo "<pre style='color:#ff8545; clear: both;'>";
                            print_r($item);
                            echo "</pre>";
                            if($item['L'] === null ) { // || ($item['L'] < ($distanceTraveled + $verFintd->getForm()))
                                $item['L'] = $verFintd->getWeight() + $distanceTraveled;
                                $item['Q'] = $verFintd->getForm();
                            }else{

                            }


                            echo "<pre style='color:#ff8545; clear: both;'>";
                            print_r($item);
                            echo "</pre>";
                        }
                    }
                    $arIterators[$i][] = $item;

                }
                unset($item);
                foreach ($arIterators[$i] as $arIterator) {
                    if($arIterator['CONST'] === true ||  $arIterator['L'] === null){
                        continue;
                    }
                    $arMinWight[] = $arIterator['L'];
                }
                // TODO DEL THIS
                echo "<pre style='color:#1917ff; clear: both;'>";
                print_r($arMinWight);
                echo "</pre>";
                unset($arIterator);
                $miniWight = min($arMinWight);
                foreach ($arIterators[$i] as &$arIterator) {
                    if ($arIterator['L'] === $miniWight) {
                        $arIterator['CONST'] = true;
                        $lastConst = $arIterator['V'];
                        $arIdVertWight[$lastConst] = $miniWight;
                        break;
                    }
                }
                unset($arIterator);
                //break;
            }

            foreach ($arIterators[$i] as $arIterator) {
                if ($arIterator['V'] === $this->finish && $arIterator['CONST'] === true) {
                    break 2;
                }
            }

            //echo "<hr />";
            $i++;
            if($i >100 ){
                // TODO DEL THIS
                echo "<pre style='color:red; clear: both;'>";
                print_r($i);
                echo "</pre>";
                break;
            }
        }

        echo "<table border='1'>";
        foreach ($arIterators as $arIterator) {
            ?><tr><?php
            foreach ($arIterator as $item) {
                ?><td <?php if($item['CONST'] === true){?> bgcolor="green" <?} ?>><b><?php echo $item['V']; ?></b><br/><?php // TODO DEL THIS
                ?>L[<?php echo $item['L']; ?>]<br/><?php
                ?>Q[<?php echo $item['Q']; ?>]<br/><?php
                ?></td><?
            }


            ?></tr><?php
        }
        echo "</table>";

        // TODO DEL THIS
        echo "<pre style='color:#228011; clear: both;'>";
        print_r($arIterators);
        echo "</pre>";
    }
}