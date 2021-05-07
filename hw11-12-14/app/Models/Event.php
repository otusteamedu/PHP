<?php

namespace App\Models;

use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\ArrayShape;
use App\Repositories\RedisEventRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Event extends BaseModel
{
    private const REDIS_PREFIX = 'events';

    /**
     * @var ?string
     */
    private ?string $id;

    /**
     * @var int|null
     */
    private ?int $priority;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var array|null
     */
    private ?array $conditions;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var bool
     */
    private bool $isInitialized = false;

    /**
     * Event constructor.
     *
     * @param ContainerInterface $container
     * @param string|null $id
     * @param int|null $priority
     * @param string|null $name
     * @param array|null $conditions
     */
    #[NoReturn]
    public function __construct(
        ContainerInterface $container,
        ?string $id = null,
        ?int $priority = null,
        ?string $name = null,
        ?array $conditions = null
    )
    {
        //Circular reference detected for service, can\'t inject repo directly
        $this->container = $container;
        $this->setId($id);
        $this->setName($name);
        $this->setPriority($priority);
        $this->setConditions($conditions);
    }

    /**
     * @return ?string
     */
    public function getId(): ?string
    {
        $this->loadIfNotLoaded();

        return $this->id;
    }

    /**
     * @param ?string $id
     *
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        $this->loadIfNotLoaded();

        return $this->priority;
    }

    /**
     * @param int|null $priority
     *
     * @return $this
     */
    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        $this->loadIfNotLoaded();

        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return self::REDIS_PREFIX;
    }

    /**
     * @return string
     */
    public static function getPrefixStatic(): string
    {
        return self::REDIS_PREFIX;
    }

    /**
     * @return array|null
     */
    public function getConditions(): ?array
    {
        $this->loadIfNotLoaded();

        return $this->conditions;
    }

    /**
     * @param array|null $conditions
     *
     * @return $this
     */
    public function setConditions(?array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Loads data if model is not initialized
     */
    private function loadIfNotLoaded()
    {
        if (!$this->isInitialized && $this->name) {
            $repository = $this->container->get('redis.event.repo');

            $retrievedModel = unserialize($repository->getEventByKeys($this->name));
            $this->setId($retrievedModel->getId());
            $this->setName($retrievedModel->getName());
            $this->setPriority($retrievedModel->getPriotity());
            $this->setConditions($retrievedModel->getConditions());

            $this->isInitialized = true;
        }
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "null|string", 'priority' => "int|null", 'name' => "null|string", 'conditions' => "array|null"])]
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'name' => $this->getName(),
            'conditions' => $this->getConditions()
        ];
    }
}
