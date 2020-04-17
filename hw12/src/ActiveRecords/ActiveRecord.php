<?php


namespace HW\ActiveRecords;


abstract class ActiveRecord
{
    /** @var \PDO  */
    protected $pdo;
    protected $id = null;

    protected $fieldValues = [];

    /**
     * @var \PDOStatement
     */
    private $stmtUpdate;

    /**
     * @var \PDOStatement
     */
    private $stmtInsert;

    /**
     * @var \PDOStatement
     */
    private $stmtDelete;


    public function __construct(\PDO $pdo, $id = null)
    {
        $this->pdo = $pdo;
        $this->id = $id;

        $this->setStmtInsert();
        $this->setStmtUpdate();
        $this->setStmtDelete();

//        foreach (static::getFieldsNames() as $name)
//            $this->fields[$name] = '';
    }

    protected function setFieldValue($fieldName, $value)
    {
        $this->fieldValues[static::getFieldIndex($fieldName)] = $value;
        return $this;
    }

    protected function getFieldValue($fieldName)
    {
        return $this->fieldValues[static::getFieldIndex($fieldName)];
    }

    protected static function getFieldIndex($fieldName)
    {
        return array_search(static::getFieldsNames(), $fieldName);
    }


    abstract protected static function getTableName();


    /**
     * @return \PDOStatement
     */
    private function setStmtInsert()
    {
        $table = static::getTableName();
        $fields = static::getFieldsNames();
        $values = array_fill(0, count($fields), '?');

        $fields = implode(',', $fields);
        $values = implode(',', $values);

        $query = "insert into $table ($fields) values ($values)";
        $this->stmtInsert = $this->pdo->prepare($query);
    }

    private function setStmtUpdate()
    {
        $table = static::getTableName();

        foreach (static::getFieldsNames() as $field)
            $set[] = "$field = ?";
        $set = implode(', ', $set);

        $query = "update $table set $set where id = ?";
        $this->stmtUpdate = $this->pdo->prepare($query);
    }

    private function setStmtDelete()
    {
        $table = static::getTableName();
        $this->stmtDelete = $this->pdo->prepare("delete from $table where id = ?");
    }


    /**
     * @return string[]
     */
    abstract protected static function getFieldsNames();


    protected function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    public function insert()
    {
        $result = $this->stmtInsert->execute($this->fieldValues);

        if ($result)
            $this->id = $this->pdo->lastInsertId();

        return $result;
    }

    public function update()
    {
        return $this->stmtUpdate->execute($this->fieldValues);
    }

    public function delete()
    {
        $id = $this->getId();
        $this->setId(null);
        return $this->stmtDelete->execute([$id]);
    }


    /**
     * @param \PDO $pdo
     * @param $id
     * @return static
     */
    public static function getById(\PDO $pdo, $id)
    {

        $fields = implode(',', static::getFieldsNames());
        $table = static::getTableName();

        $query = "SELECT $fields FROM $table WHERE id = ?";
        $st = $pdo->prepare($query);
        $st->setFetchMode(\PDO::FETCH_ASSOC);
        $st->execute([$id]);
        $result = $st->fetch();

        if (!is_array($result) || empty($result))
            return null;

        $inst = new static($pdo, $id);
        $inst->fieldValues = array_values($result);
        return $inst;
    }


    /**
     * @param \PDO $pdo
     * @return static[]
     */
    public static function getCollection(\PDO $pdo, $where = null)
    {
        $fields = implode(',', static::getFieldsNames());
        $fields = 'id, ' . $fields;

        $table = static::getTableName();

        $query = "SELECT $fields FROM $table";

        if ($where)
            $query .= " WHERE $where";

        $st = $pdo->prepare($query);
        $st->setFetchMode(\PDO::FETCH_ASSOC);
        $st->execute();
        $rows = $st->fetchAll();

        $collection = [];
        foreach ($rows as $row) {
            $id = $row['id'];
            $values = array_slice(array_values($row), 1);

            $inst = new static($pdo, $id);
            $inst->fieldValues = $values;
            $collection[$id] = $inst;
        }
        return $collection;
    }






}