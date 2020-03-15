<?php

namespace Tirei01\Hw15\Dijkstra;

class Vertex
{
    private int $form;
    private int $to;
    private int $weight;
    private int $l;
    private int $q;
    private int $constant;
    private Graph $graph;
    public function __construct(int $form, int $to, int $weight, Graph $graph)
    {
        $this->form = $form;
        $this->to = $to;
        $this->weight = $weight;
        $this->graph = $graph;
        $this->graph->addVertex($this);
    }

    /**
     * @return int
     */
    public function getForm(): int
    {
        return $this->form;
    }

    /**
     * @param int $form
     */
    public function setForm(int $form): void
    {
        $this->form = $form;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * @param int $to
     */
    public function setTo(int $to): void
    {
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getL(): int
    {
        return $this->l;
    }

    /**
     * @param int $l
     */
    public function setL(int $l): void
    {
        $this->l = $l;
    }

    /**
     * @return int
     */
    public function getQ(): int
    {
        return $this->q;
    }

    /**
     * @param int $q
     */
    public function setQ(int $q): void
    {
        $this->q = $q;
    }

    /**
     * @return int
     */
    public function getConstant(): int
    {
        return $this->constant;
    }

    /**
     * @param int $constant
     */
    public function setConstant(int $constant): void
    {
        $this->constant = $constant;
    }

}