<?php

namespace Otus;


use PDO;

class Creator
{

    /**
     * PDO object
     * @var PDO
     */
    private $pdo;

    /**
     * init the object with a \PDO object
     * @param type $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * create default tables
     */
    public function createDefaultTables()
    {

    }

    public function createTableAttributeName($database, $user)
    {
        $this->pdo->exec('CREATE TABLE ' . $database . '.attribute_name (
            id bigint NOT NULL,
            title character varying(255) NOT NULL
        );');
        $this->pdo->exec('ALTER TABLE' . $database . '.attribute_name OWNER TO ' . $user . ';');
        $this->pdo->exec('CREATE SEQUENCE test_db.attribute_name_id_seq
                                    START WITH 1
                                    INCREMENT BY 1
                                    NO MINVALUE
                                    NO MAXVALUE
                                    CACHE 1;');
        $this->pdo->exec('ALTER TABLE test_db.attribute_name_id_seq OWNER TO postgres;');
        $this->pdo->exec('ALTER SEQUENCE test_db.attribute_name_id_seq OWNED BY test_db.attribute_name.id;');
    }

    /**
     * return tables in the database
     */
    public function getTables()
    {

    }
}