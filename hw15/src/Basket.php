<?php


namespace App;


class Basket
{
    /** @var Product[] */
    private $products;
    private $counts;

    public function getProducts()
    {
        return $this->products;
    }

    public function count($productID)
    {
        return $this->counts[$productID] ?? 0;
    }

    public function add(Product $product, $count = 1)
    {
        $id = $product->getId();
        $this->incr($id, $count);
        $this->products[$id] = $product;
        return $this;
    }

    public function delete(Product $good, $count = 1)
    {
        $id = $good->getId();
        if (!$this->exists($id))
            return $this;

        return $this->decr($id, $count);
    }

    public function clear($productID)
    {
        unset($this->counts[$productID]);
        unset($this->products[$productID]);
        return $this;
    }

    private function exists($productID)
    {
        return ($this->counts[$productID] ?? 0) > 0;
    }

    private function incr($productID, $count = 1)
    {
        $this->counts[$productID] = ($this->counts[$productID] ?? 0) + $count;
        return $this;
    }

    private function decr($productID, $count = 1)
    {
        $this->counts[$productID] -= $count;

        if (!$this->exists($productID))
            $this->clear($productID);

        return $this;
    }



}