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
     * Connection data
     * @var
     */
    private $connectionData;

    /**
     * init the object with a \PDO object
     * @param type $pdo
     * @param type $connectionData
     */
    public function __construct($pdo, $connectionData)
    {
        $this->pdo = $pdo;
        $this->connectionData = $connectionData;
    }

    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }


    public function checkDb(): bool
    {
        return (bool)$this->pdo->query("SELECT pg_database.datname FROM pg_database WHERE pg_database.datname like '" . $this->connectionData['database'] . "'")->rowCount();
    }

    public function createDb()
    {
        $this->pdo->exec('CREATE DATABASE ' . $this->connectionData['database'] . ';');
    }

    public function checkSchema(): bool
    {
        return (bool)$this->pdo->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '" . $this->connectionData['schema'] . "'")->rowCount();
    }

    public function dropSchema()
    {
        $this->pdo->exec('DROP SCHEMA IF EXISTS ' . $this->connectionData['schema'] . ' CASCADE;');
    }

    public function createSchema()
    {
        $this->pdo->exec('CREATE SCHEMA ' . $this->connectionData['schema'] . ';');
    }

    public function createTable(string $tableName, array $columns)
    {
        $this->pdo->exec('CREATE TABLE ' . $this->connectionData['schema'] . '.' . $tableName . ' ( ' . implode(', ', $columns) . ');');
    }

    public function dropTable(string $tableName)
    {
        $this->pdo->exec('DROP TABLE IF EXISTS ' . $this->connectionData['schema'] . '.' . $tableName . ' CASCADE;');
    }

    public function setTableOwner(string $tableName, string $owner)
    {
        $this->pdo->exec('ALTER TABLE ' . $this->connectionData['schema'] . '.' . $tableName . ' OWNER TO ' . $owner . ';');
    }

    public function createSequence(string $sequenceName, array $params)
    {
        $this->pdo->exec('CREATE SEQUENCE ' . $this->connectionData['schema'] . '.' . $sequenceName . ' ' . implode(' ', $params) . ';');
    }

    public function setSequenceOnColumn(string $sequenceName, string $tableName, string $columnName)
    {
        $this->pdo->exec('ALTER SEQUENCE ' . $this->connectionData['schema'] . '.' . $sequenceName . ' OWNED BY ' . $this->connectionData['schema'] . '.' . $tableName . '.' . $columnName . ';');
    }

    public function createView(string $name, string $query)
    {
        $this->pdo->exec('CREATE OR REPLACE VIEW ' . $this->connectionData['schema'] . '.' . $name . ' AS ' . $query . ';');
    }

    public function setSequenceNextval(string $tableName, string $column, string $sequence)
    {
        $this->pdo->exec('ALTER TABLE ONLY ' . $this->connectionData['schema'] . '.' . $tableName . ' ALTER COLUMN ' . $column . " SET DEFAULT nextval('" . $this->connectionData['schema'] . '.' . $sequence . "'::regclass);");
    }

    public function addConstraint(string $tableName, string $indexName, string $column, string $type = 'PRIMARY KEY', string $references = null)
    {
        $this->pdo->exec('ALTER TABLE ONLY ' . $this->connectionData['schema'] . '.' . $tableName . ' ADD CONSTRAINT ' . $indexName . ' ' . $type . ' (' . $column . ')' . ($references ? ' REFERENCES ' . $this->connectionData['schema'] . '.' . $references : '' ) . ';');
    }

    public function addIndex(string $tableName, string $indexName, string $column, bool $unique = false)
    {
        $this->pdo->exec('CREATE ' . ($unique ? 'UNIQUE' : '') . ' INDEX ' . $indexName . ' ON ' . $this->connectionData['schema'] . '.' . $tableName . ' USING btree (' . $column . ');');
    }
    /**
     * create default tables
     */
    public function createDefaultTables()
    {
        $this->createTableAttributeName();
        $this->createTableAttributeType();
        $this->createTableAttributeValue();
        $this->createTableFilm();
        $this->createTableFilmAttribute();
        $this->createTableGenre();
        $this->createTableHall();
        $this->createTableSeance();
        $this->createTableSeat();
        $this->createTableTicket();
        $this->createMarketView();
        $this->setSequences();
        $this->addIndexes();
        $this->createWorkTasksView();
    }

    private function createTableAttributeName()
    {
        $this->dropTable('attribute_name');
        $this->createTable('attribute_name', ['id bigint NOT NULL', 'title character varying(255) NOT NULL']);
        $this->setTableOwner('attribute_name', $this->connectionData['user']);
        $this->createSequence('attribute_name_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('attribute_name_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('attribute_name_id_seq', 'attribute_name', 'id');
    }

    private function createTableAttributeType()
    {
        $this->dropTable('attribute_type');
        $this->createTable('attribute_type', ['id bigint NOT NULL', 'title character varying(255) NOT NULL', 'code character varying(45) NOT NULL', 'type character varying(45) NOT NULL']);
        $this->setTableOwner('attribute_type', $this->connectionData['user']);
        $this->createSequence('attribute_type_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('attribute_type_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('attribute_type_id_seq', 'attribute_type', 'id');
    }

    private function createTableAttributeValue()
    {
        $this->dropTable('attribute_value');
        $this->createTable('attribute_value', ['id bigint NOT NULL', 'bool_val boolean DEFAULT false', 'int_val bigint', 'date_val timestamp with time zone', 'text_val text']);
        $this->setTableOwner('attribute_value', $this->connectionData['user']);
        $this->createSequence('attribute_value_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('attribute_value_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('attribute_value_id_seq', 'attribute_value', 'id');
    }

    private function createTableFilm()
    {
        $this->dropTable('film');
        $this->createTable('film', ['id bigint NOT NULL', 'title character varying(255) NOT NULL', 'genre_id bigint', 'duration bigint', 'annotation text']);
        $this->setTableOwner('film', $this->connectionData['user']);
        $this->createSequence('film_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('film_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('film_id_seq', 'film', 'id');
    }

    private function createTableFilmAttribute()
    {
        $this->dropTable('film_attribute');
        $this->createTable('film_attribute', ['id bigint NOT NULL', 'attribute_name_id bigint NOT NULL', 'film_id bigint NOT NULL', 'attribute_value_id bigint NOT NULL', 'attribute_type_id bigint NOT NULL']);
        $this->setTableOwner('film_attribute', $this->connectionData['user']);
        $this->createSequence('film_attribute_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('film_attribute_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('film_attribute_id_seq', 'film_attribute', 'id');
    }

    private function createTableGenre()
    {
        $this->dropTable('genre');
        $this->createTable('genre', ['id bigint NOT NULL', 'title character varying(255) NOT NULL']);
        $this->setTableOwner('genre', $this->connectionData['user']);
        $this->createSequence('genre_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('genre_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('genre_id_seq', 'genre', 'id');
    }

    private function createTableHall()
    {
        $this->dropTable('hall');
        $this->createTable('hall', ['id bigint NOT NULL', 'seats integer NOT NULL', 'some_staff character varying(45)', 'title character varying(45)']);
        $this->setTableOwner('hall', $this->connectionData['user']);
        $this->createSequence('hall_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('hall_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('hall_id_seq', 'hall', 'id');
    }

    private function createTableSeance()
    {
        $this->dropTable('seance');
        $this->createTable('seance', ['id bigint NOT NULL', 'hall_id bigint NOT NULL', 'date_start timestamp with time zone', 'date_end timestamp with time zone', 'film_id bigint NOT NULL']);
        $this->setTableOwner('seance', $this->connectionData['user']);
        $this->createSequence('seance_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('seance_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('seance_id_seq', 'seance', 'id');
    }

    private function createTableSeat()
    {
        $this->dropTable('seat');
        $this->createTable('seat', ['id bigint NOT NULL', 'hall_id bigint NOT NULL', 'line integer NOT NULL', 'number integer NOT NULL']);
        $this->setTableOwner('seat', $this->connectionData['user']);
        $this->createSequence('seat_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('seat_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('seat_id_seq', 'seat', 'id');
    }

    private function createTableTicket()
    {
        $this->dropTable('ticket');
        $this->createTable('ticket', ['id bigint NOT NULL', 'seance_id bigint NOT NULL', 'seat_id bigint NOT NULL', 'price bigint DEFAULT \'0\'::bigint']);
        $this->setTableOwner('ticket', $this->connectionData['user']);
        $this->createSequence('ticket_id_seq', ['START WITH 1', 'INCREMENT BY 1', 'NO MINVALUE', 'NO MAXVALUE', 'CACHE 1']);
        $this->setTableOwner('ticket_id_seq', $this->connectionData['user']);
        $this->setSequenceOnColumn('ticket_id_seq', 'ticket', 'id');
    }

    private function createMarketView()
    {
        $sql = "(SELECT film.title,
                    attribute_type.title AS type,
                    attribute_name.title AS attribute,
                CASE attribute_type.type
                    WHEN 'integer'::text THEN (attribute_value.int_val)::text
                    WHEN 'timestamp'::text THEN (attribute_value.date_val)::text
                    WHEN 'text'::text THEN attribute_value.text_val
                    WHEN 'boolean'::text THEN (attribute_value.bool_val)::text
                ELSE NULL::text
                END AS value
                FROM ((((" . $this->connectionData['schema'] . ".film
                LEFT JOIN " . $this->connectionData['schema'] . ".film_attribute ON ((film.id = film_attribute.film_id)))
                LEFT JOIN " . $this->connectionData['schema'] . ".attribute_name ON ((film_attribute.attribute_name_id = attribute_name.id)))
                LEFT JOIN " . $this->connectionData['schema'] . ".attribute_type ON ((film_attribute.attribute_type_id = attribute_type.id)))
                LEFT JOIN " . $this->connectionData['schema'] . ".attribute_value ON ((film_attribute.attribute_value_id = attribute_value.id)))
                ORDER BY film.id)";
        $this->createView('market_view', $sql);
        $this->setTableOwner('market_view', $this->connectionData['user']);
    }

    private function createWorkTasksView()
    {
        $sql = "(SELECT film.title,
                    string_agg(DISTINCT (today_work.title)::text, ', '::text) AS today,
                    string_agg(DISTINCT (future_work.title)::text, ','::text) AS future
                FROM ((" . $this->connectionData['schema'] . ".film
                LEFT JOIN ( 
                    SELECT fa_today.film_id,
                        a_today.title
                    FROM (((" . $this->connectionData['schema'] . ".film_attribute fa_today
                    LEFT JOIN " . $this->connectionData['schema'] . ".attribute_name a_today ON ((fa_today.attribute_name_id = a_today.id)))
                    LEFT JOIN " . $this->connectionData['schema'] . ".attribute_type at_today ON (((fa_today.attribute_type_id = at_today.id) AND ((at_today.code)::text = 'work'::text))))
                    LEFT JOIN " . $this->connectionData['schema'] . ".attribute_value av_today ON ((fa_today.attribute_value_id = av_today.id)))
                    WHERE (date(av_today.date_val) = CURRENT_DATE)) today_work ON ((film.id = today_work.film_id)))
                LEFT JOIN ( 
                    SELECT fa_future.film_id,
                        a_future.title
                    FROM (((" . $this->connectionData['schema'] . ".film_attribute fa_future
                    LEFT JOIN " . $this->connectionData['schema'] . ".attribute_name a_future ON ((fa_future.attribute_name_id = a_future.id)))
                    LEFT JOIN " . $this->connectionData['schema'] . ".attribute_type at_future ON (((fa_future.attribute_type_id = at_future.id) AND ((at_future.code)::text = 'work'::text))))
                    LEFT JOIN " . $this->connectionData['schema'] . ".attribute_value av_future ON ((fa_future.attribute_value_id = av_future.id)))
                    WHERE (date(av_future.date_val) = (CURRENT_DATE + '20 days'::interval))) future_work ON ((film.id = future_work.film_id)))
                GROUP BY film.id)";
        $this->createView('work_tasks', $sql);
        $this->setTableOwner('work_tasks', $this->connectionData['user']);
    }

    private function setSequences()
    {
        $this->setSequenceNextval('attribute_name', 'id', 'attribute_name_id_seq');
        $this->setSequenceNextval('attribute_type', 'id', 'attribute_type_id_seq');
        $this->setSequenceNextval('attribute_value', 'id', 'attribute_value_id_seq');
        $this->setSequenceNextval('film', 'id', 'film_id_seq');
        $this->setSequenceNextval('film_attribute', 'id', 'film_attribute_id_seq');
        $this->setSequenceNextval('genre', 'id', 'genre_id_seq');
        $this->setSequenceNextval('hall', 'id', 'hall_id_seq');
        $this->setSequenceNextval('seance', 'id', 'seance_id_seq');
        $this->setSequenceNextval('seat', 'id', 'seat_id_seq');
        $this->setSequenceNextval('ticket', 'id', 'ticket_id_seq');
    }

    private function addIndexes()
    {
        $this->addConstraint('attribute_name', 'idx_attr_name_primary', 'id');
        $this->addConstraint('attribute_type', 'idx_attr_type_primary', 'id');
        $this->addConstraint('attribute_value', 'idx_attr_value_primary', 'id');
        $this->addConstraint('film', 'idx_film_primary', 'id');
        $this->addConstraint('film_attribute', 'idx_film_attr_primary', 'id');
        $this->addConstraint('genre', 'idx_genre_primary', 'id');
        $this->addConstraint('hall', 'idx_hall_primary', 'id');
        $this->addConstraint('seance', 'idx_seance_primary', 'id');
        $this->addConstraint('seat', 'idx_seat_primary', 'id');
        $this->addConstraint('ticket', 'idx_ticket_primary', 'id');
        $this->addIndex('attribute_name', 'idx_attr_name_title_unique', 'title', true);
        $this->addIndex('attribute_type', 'idx_attr_type_title_unique', 'title', true);
        $this->addIndex('film', 'idx_films_to_genre_idx', 'genre_id');
        $this->addIndex('film_attribute', 'idx_attribute_to_value_idx', 'attribute_value_id');
        $this->addIndex('film_attribute', 'idx_attribute_to_name_idx', 'attribute_name_id');
        $this->addIndex('film_attribute', 'idx_attribute_to_type_idx', 'attribute_type_id');
        $this->addIndex('film_attribute', 'idx_films_attributes_idx', 'film_id');
        $this->addIndex('seance', 'idx_seance_to_film_idx', 'film_id');
        $this->addIndex('seance', 'idx_seance_to_hall_idx', 'hall_id');
        $this->addIndex('seat', 'idx_seats_to_hall_idx', 'hall_id');
        $this->addIndex('seat', 'idx_uniq_seat', 'hall_id, line, number', true);
        $this->addIndex('ticket', 'idx_ticket_to_seance_idx', 'seance_id');
        $this->addIndex('ticket', 'idx_ticket_to_seat_idx', 'seat_id');
        $this->addIndex('ticket', 'idx_uniq_seance_seat', 'seance_id, seat_id', true);
        $this->addConstraint('film_attribute', 'attribute_to_value', 'attribute_value_id', 'FOREIGN KEY', 'attribute_value(id)');
        $this->addConstraint('film_attribute', 'attribute_to_name', 'attribute_name_id', 'FOREIGN KEY', 'attribute_name(id)');
        $this->addConstraint('film_attribute', 'attribute_to_type', 'attribute_type_id', 'FOREIGN KEY', 'attribute_type(id)');
        $this->addConstraint('film_attribute', 'films_attributes', 'film_id', 'FOREIGN KEY', 'film(id)');
        $this->addConstraint('film', 'films_to_genre', 'genre_id', 'FOREIGN KEY', 'genre(id)');
        $this->addConstraint('seance', 'seance_to_film', 'film_id', 'FOREIGN KEY', 'film(id)');
        $this->addConstraint('seance', 'seance_to_hall', 'hall_id', 'FOREIGN KEY', 'hall(id)');
        $this->addConstraint('seat', 'seats_to_hall', 'hall_id', 'FOREIGN KEY', 'hall(id)');
        $this->addConstraint('ticket', 'ticket_to_seance', 'seance_id', 'FOREIGN KEY', 'seance(id)');
        $this->addConstraint('ticket', 'ticket_to_seats', 'seat_id', 'FOREIGN KEY', 'seat(id)');
    }

    /**
     * return tables in the database
     */
    public function getTables()
    {

    }
}