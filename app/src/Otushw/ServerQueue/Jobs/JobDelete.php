<?php


namespace Otushw\ServerQueue\Jobs;


class JobDelete extends Job
{
    private int $orderID;

    public function __construct(int $orderID)
    {
        parent::__construct();
        $this->orderID = $orderID;
    }

    public function work(): bool
    {
        return $this->mapper->delete($this->orderID);
    }
}