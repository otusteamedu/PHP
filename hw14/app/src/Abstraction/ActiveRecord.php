<?php
/**
* Abstract realization of ActiveRecord pattern
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Abstraction;

use Jekys\Main\DatabaseTable;

abstract class ActiveRecord
{
    /**
    * @var string - Table name
    */
    protected $tablename;

    /**
    * @var array - List of editable fields
    */
    protected $fillable = [];

    /**
    * @var array - List of fields to load at first object call
    */
    protected $onload = [];

    /**
    * @var Jekys\Main\DatabaseTable
    */
    private $table;

    /**
    * @var array - List of entity fields and their values
    */
    private $fields = [];

    /**
    * @var array - List of changed fields since last object save
    */
    private $changed = [];

    /**
    * @var array - List of fields loaded after object creation
    */
    private $lazyloaded = [];

    /**
    * @var array - Array of prepared queries
    */
    private $queries = [];

    use \Jekys\Traits\ObjectMapper;
    use \Jekys\Traits\DbConnection;

    /**
    * Object entity constructor
    *
    * @throws \Exception
    *
    * @return void
    */
    public function __construct()
    {
        $this->table = DatabaseTable::get($this->tablename);

        if (!array_key_exists('primary', $this->table->fields)) {
            throw new \Exception('This table hasn`t "id" field');
        }

        $this->existsInTable($this->fillable);
        $this->existsInTable($this->onload);

        $fields = array_merge(
            $this->table->fields['required'],
            $this->table->fields['nullable']
        );

        $values = array_fill(0, count($fields), null);

        $this->fields = array_combine($fields, $values);

        $this->prepareQueries();
    }

    /**
    * Check that all fields in array exists in the database table
    *
    * @param array $fields
    *
    * @throws \Exception
    *
    * @return void
    */
    private function existsInTable(array $fields): void
    {
        foreach ($fields as $field) {
            if (!in_array($field, $this->table->fields['required'])
                && !in_array($field, $this->table->fields['nullable'])
            ) {
                throw new \Exception('Field '.$field.' doesn`t exists');
            }
        }
    }

    /**
    * Create all prepared queries
    *
    * @return void
    */
    public function prepareQueries(): void
    {
        $fields = array_unique(array_merge($this->onload, ['id']));

        $this->queries['load'] = $this->db()->prepare(
            'SELECT 
                '.implode(',', $fields).' 
            FROM 
                '.$this->tablename.'
            WHERE 
                id = ?'
        );

        $this->queries['delete'] = $this->db()->prepare('DELETE FROM '.$this->tablename.' WHERE id = ?');
    }

    /**
    * Magic setter for entity fields
    *
    * @param string $field
    * @param mixed $value
    *
    * @return void
    */
    public function __set(string $field, $value)
    {
        if (in_array($field, $this->fillable)) {
            $this->changed[$field] = $value;
        }
    }

    /**
    * Magic getter for entity fields
    *
    * @param string $field
    *
    * @return mixed
    */
    public function __get($field)
    {
        if (array_key_exists($field, $this->fields)) {
            if (!in_array($field, $this->onload) && !in_array($field, $this->lazyloaded)) {
                $this->loadLazyField($field);
            }

            return $this->fields[$field];
        }
    }

    /**
    * Load data from database to the object fields
    *
    * @param int $id
    *
    * @return bool
    */
    private function load(int $id): bool
    {
        $stmt = $this->queries['load'];
        $stmt->execute([$id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($result)) {
            foreach ($result as $field => $value) {
                $this->fields[$field] = $value;
            }

            self::mapper()->registerObject($this, $id);

            return true;
        } else {
            return false;
        }
    }

    /**
    * Load database value to the entity field
    *
    * @param string $field
    *
    * @return void
    */
    private function loadLazyField($field): void
    {
        $stmt = $this->db()->prepare('SELECT '.$field.' FROM '.$this->tablename.' WHERE id = ?');
        $stmt->execute([$this->id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $this->fields[$field] = $result[$field];
            $this->lazyloaded[]= $field;
        }
    }

    /**
    * Checks changed fields before save
    *
    * @throws \Exception
    *
    * @return bool
    */
    public function checkChanged(): bool
    {
        foreach ($this->table->fields['required'] as $field) {
            if (array_key_exists($field, $this->changed)) {
                if (empty($this->changed[$field])) {
                    throw new \Exception('Field "'.$field.'" couldn`t be empty');

                    return false;
                }
            } elseif (empty($this->fields['id'])) {
                throw new \Exception('Field "'.$field.'" is required');

                return false;
            }
        }

        return true;
    }

    /**
    * Create or update data in the database
    *
    * @return bool
    */
    public function save(): bool
    {
        if (!empty($this->changed) && $this->checkChanged()) {
            $values = array_values($this->changed);

            if ($this->id) {
                $set = [];
                foreach (array_keys($this->changed) as $key) {
                    $set[] = $key.' = ?';
                }

                $query = 'UPDATE 
                    '.$this->tablename.' 
                SET 
                    '.implode(',', $set).'   
                WHERE 
                    id = '.$this->id;
            } else {
                $fields = array_keys($this->changed);
                $template = array_fill(0, count($values), '?');

                $query = 'INSERT INTO
                    '.$this->tablename.' 
                    ('.implode(',', $fields).')
                VALUES 
                    ('.implode(',', $template).')';
            }

            $stmt = $this->db()->prepare($query);
            $saved = $stmt->execute($values);

            if ($saved) {
                if (!$this->id) {
                    $this->changed['id'] = $this->db()->lastInsertId($this->tablename.'_id_seq');
                }

                foreach ($this->changed as $field => $value) {
                    $this->fields[$field] = $value;
                }

                $this->changed = [];
            }

            return $saved;
        }
    }

    /**
    * Delete the row from database
    *
    * @return bool
    */
    public function delete(): bool
    {
        $stmt = $this->queries['delete'];

        if ($stmt->execute([$this->id])) {
            $this->mapper()->deleteObject(__CLASS__, $this->id);
            unset($this->fields['id']);

            return true;
        } else {
            return false;
        }
    }

    /**
    * Returns object by id
    *
    * @param int $id
    *
    * @return null|object
    */
    public static function find(int $id): ?object
    {
        $object = self::mapper()->getObject(__CLASS__, $id);
        if (!$object) {
            $class = get_called_class();
            $entity = new $class;
            if ($entity->load($id)) {
                $object = $entity;
            }
        }

        return $object;
    }
}
