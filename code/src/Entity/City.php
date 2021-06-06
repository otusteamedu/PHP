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
 * @ORM\Table(name="cities")
 * @ORM\HasLifecycleCallbacks()
 *
 * @OA\Schema()
 */
class City implements \JsonSerializable
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @OA\Property(property="id", type="integer", description="ID города", example="123")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @OA\Property(property="name", type="string", description="Название города", example="Тамбов")
     */
    protected string $name;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \App\Entity\City
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAtDateAtom(),
        ];
    }
}
