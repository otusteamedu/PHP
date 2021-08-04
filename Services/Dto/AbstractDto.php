<?php


namespace Services\Dto;


use Services\Traits\HasObjectTools;

/**
 * Class AbstractDto
 * @package Services\Dto
 */
abstract class AbstractDto
{
    use HasObjectTools;

    /**
     * AbstractDto constructor.
     * @param null $data
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->populate($data);
        }
    }

    /**
     * Заполняет данными свойства dto на основании $data
     *
     * @param $data
     * @return $this
     */
    public function populate($data): self
    {
        if (is_array($data) || is_object($data)) {
            $object = is_object($data) ? $data : (object)$data;
            foreach (array_keys($this->getProperties()) as $property) {
                $this->{$property} = $object->{$property} ?? null;
            }
        }
        return $this;
    }

}
