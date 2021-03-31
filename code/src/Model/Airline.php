<?php


namespace App\Model;


use App\Services\Orm\ModelManager;
use Psr\Container\ContainerInterface;

class Airline extends OrmAbstractModel
{
    private ModelManager $modelManager;
    private ?string $name;
    private ?string $abbreviation;
    private ?string $description;

    /**
     * Airline constructor.
     * @param ModelManager $modelManager
     */
    public function __construct(ModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
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
     */
    public function setName(string $name): self
    {
        $this->name = $name;
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
     */
    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;
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
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getAirplanes(): array
    {
        return $this->modelManager
            ->getRepository('Airplane')
            ->find(['airline_id' => $this->getId()]);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
