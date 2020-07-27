<?php


namespace AYakovlev\Model;


use AYakovlev\Core\Db;
use ReflectionObject;

abstract class ActiveRecordEntity
{
    protected ?int $id = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value): void
    {
        $camelCaseName = $this->underscoreToCamel($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamel(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    /**
     * @return static[]
     */
    public static function getAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        /** @noinspection SqlResolve */
        $entities = $db->query(
            "SELECT * FROM " . static::getTableName() . " WHERE id = :id;",
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    abstract protected static function getTableName(): string;

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $column2params = [];
        $params2values = [];
        $idx = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $idx; // :param1
            $column2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1];
            $idx++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $column2params) . ' WHERE id = ' . $this->id;
        $db  = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);
        $columns = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = $columnName;
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query(
            'DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }
}
