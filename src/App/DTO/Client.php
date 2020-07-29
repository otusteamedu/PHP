<?php

namespace Ozycast\App\DTO;

use Ozycast\App\Core\DTO;

Class Client extends DTO
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $company_id;
    /**
     * @var int
     */
    private $sale;
    /**
     * @var int
     */
    private $status = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     */
    public function setCompanyId(int $company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return int
     */
    public function getSale(): int
    {
        return $this->sale;
    }

    /**
     * @param int $sale
     */
    public function setSale(int $sale)
    {
        $this->sale = $sale;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

}