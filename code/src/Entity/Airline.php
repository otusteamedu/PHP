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
 * @ORM\Table(name="airlines")
 * @ORM\HasLifecycleCallbacks
 *
 * @OA\Schema ()
 *
 */
class Airline implements \JsonSerializable
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @OA\Property(property="id", type="integer", description="ID авиакомпании", example="123")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     *
     * @OA\Property(property="title", type="string", description="Название авиакомпании", example="Аэроком")
     */
    protected string $title;

    /**
     * @ORM\Column(type="text")
     *
     * @OA\Property(property="description", type="string", description="Описание компании", example="Аэроком лучшая компания")
     */
    protected string $description;

    /**
     * @ORM\Column(type="string", length=3, unique=true)
     *
     * @OA\Property(property="abbreviation", type="string", description="Аббревиатура компании", example="AEK")
     */
    protected string $abbreviation;


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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return \App\Entity\Airline
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return \App\Entity\Airline
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     * @return \App\Entity\Airline
     */
    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'abbreviation' => $this->getAbbreviation(),
            'description' => $this->getDescription(),
            'created_at' => $this->getCreatedAtDateAtom(),
        ];
    }
}
