<?php


namespace App\Entity;


use App\Entity\Traits\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 *
 * @author Alexandr Timofeev <tim31al@gmail.com>
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="requests")
 * @ORM\HasLifecycleCallbacks
 *
 * @OA\Schema ()
 *
 */
class Request implements \JsonSerializable
{
    const STATUS_PENDING = 'Ожидает обработку';
    const STATUS_PROCESSING = 'В обработке';
    const STATUS_PROCESSED = 'Обработан';

    use CreatedAtTrait;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->state = self::STATUS_PENDING;
    }


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @OA\Property(property="id", type="integer", description="Номер запроса", example="123")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=30)
     *
     * @OA\Property(property="state", type="string", description="Статус запроса", example="В обработке")
     */
    protected string $state;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     *
     * @OA\Property(property="result", type="int", description="Результат обработки", example="200")
     */
    protected ?int $result;

    /**
     * @ORM\Column(type="json")
     */
    protected string $context;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }


    /**
     * @return $this
     */
    public function setStateProcessing(): self
    {
        $this->state = self::STATUS_PROCESSING;
        return $this;
    }

    /**
     * @return $this
     */
    public function setStateProcessed(): self
    {
        $this->state = self::STATUS_PROCESSED;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getResult(): ?int
    {
        return $this->result;
    }

    /**
     * @param int $result
     * @return \App\Entity\Request
     */
    public function setResult(int $result): self
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * @param string $context
     * @return \App\Entity\Request
     */
    public function setContext(string $context): self
    {
        $this->context = $context;
        return $this;
    }




    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'number' => $this->id,
            'state' => $this->state,
            'result' => $this->result,
            'created_at' => $this->getCreatedAtDateAtom(),
        ];
    }
}
