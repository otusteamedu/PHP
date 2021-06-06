<?php


namespace App\Entity\Traits;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

trait CreatedAtTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     *
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     description="Дата+время создания ",
     *     example="2020-01-01T01:01:01+00:00"
     * )
     */
    protected DateTime $createdAt;

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAtDateAtom(): string
    {
        return $this->createdAt->format(DATE_ATOM);
    }


}
