<?php
/**
* Class describes database table with fields
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Main;

class DatabaseTable
{
    /**
    * @var string - table name
    */
    private $tablename;

    /**
    * @var array - List of table fields
    */
    private $fields = [];

    /**
    * @var string - query to get all table fields
    */
    private $query = "SELECT 
            column_name, 
            data_type, 
            is_nullable
        FROM 
            INFORMATION_SCHEMA.COLUMNS 
        WHERE 
            table_name = ?";

    use \Jekys\Traits\ObjectMapper;
    use \Jekys\Traits\DbConnection;

    /**
    * Class object constructor
    * Constructor is private because objects are could be stored in the Indetity Map
    *
    * @param string $tablename
    *
    * @return void
    */
    private function __construct(string $tablename)
    {
        $this->tablename = $tablename;
        $this->load();

        self::mapper()->registerObject($this, $tablename);
    }

    /**
    * Load all fields form table schema
    *
    * @throws \Exception
    *
    * @return void
    */
    private function load()
    {
        $stmt = $this->db()->prepare($this->query);
        $stmt->execute([
            $this->tablename
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new \Exception('Table "'.$this->tablename.'" doesn`t exists');
        }

        foreach ($result as $field) {
            if ($field['column_name'] === 'id') {
                $this->fields['primary'] = 'id';
            } else {
                if ($field['is_nullable'] === 'YES') {
                    $this->fields['nullable'][] = $field['column_name'];
                } else {
                    $this->fields['required'][] = $field['column_name'];
                }
            }
        }
    }

    /**
    * Magic getter for class object properties
    *
    * @param string $param
    *
    * @return mixed
    */
    public function __get(string $param)
    {
        if ($param == 'fields' || $param == 'tablename') {
            return $this->{$param};
        }
    }

    /**
    * Returns DatabesTable object
    *
    * @param string $tablename
    *
    * @return self
    */
    public static function get(string $tablename): self
    {
        $object = self::mapper()->getObject(__CLASS__, $tablename);
        if (!$object) {
            $object = new self($tablename);
        }

        return $object;
    }
}
