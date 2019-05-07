<?php


namespace HW13_1;

use Exception;
use PDO;
use tebazil\dbseeder\FakerConfigurator;
use tebazil\dbseeder\GeneratorConfigurator;
use tebazil\dbseeder\Seeder;

class DbSeeder
{
    /**
     * @var FakerConfigurator
     */
    private $faker;
    /**
     * @var Seeder
     */
    private $seeder;
    /**
     * @var GeneratorConfigurator
     */
    private $generator;

    public function __construct()
    {
        $host = getenv('PGHOST') ?: 'localhost';
        $dbname = getenv('PGDATABSE') ?: 'mydb';
        $password = getenv('PGPASSWORD') ?: '';
        $username = getenv('PGUSER') ?: '';
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password");
        $this->seeder = new Seeder($pdo);
        $this->generator = $this->seeder->getGeneratorConfigurator();
        $this->faker = $this->generator->getFakerConfigurator();
    }

    public function seedHall(int $rows = 1): DbSeeder
    {
//        INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type) VALUES (1, 'Целое', 'integer');
        //INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type) VALUES (2, 'Текст', 'text');
        //INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type) VALUES (3, 'Дата', 'timestamp');
        //INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type) VALUES (4, 'Да/Нет', 'boolean');
        //INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type) VALUES (5, 'Раб.Дата', 'timestamp');
        $this->seeder->table('hall')->columns([
            'id_hall' => $this->generator->pk,
            'name' => $this->faker->name,
        ])->rowQuantity($rows);
        return $this;
    }

    public function seedClient(int $rows = 1): DbSeeder
    {
        $this->seeder->table('client')->columns([
            'id_client' => $this->generator->pk,
            'name' => $this->faker->name,
            'card' => $this->faker->creditCardNumber
        ])->rowQuantity($rows);
        return $this;
    }


    public function seedSession(int $rows = 1): DbSeeder
    {
        $this->seeder->table('session')->columns([
            'id_session' => $this->generator->pk,
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'id_hall' => $this->generator->relation('hall', 'id_hall'),
            'id_film' => $this->generator->relation('film', 'id_film'),
            'price' => $this->faker->randomElement([150.0, 250.0, 350.0])
        ])->rowQuantity($rows);
        return $this;
    }

    public function seedClientSession(int $rows = 1): DbSeeder
    {
        $this->seeder->table('client_session')->columns([
            'session_id_session' => $this->generator->relation('session', 'id_session'),
            'client_id_client' => $this->generator->relation('client', 'id_client')
        ])->rowQuantity($rows);
        return $this;
    }

    public function seedFilm(int $rows = 1): DbSeeder
    {
        $this->seeder->table('film')->columns([
            'id_film' => $this->generator->pk,
            'year' => $this->faker->year,
            'name' => $this->faker->name,
            'rating' => static function () {
                return random_int(0, 100) / 10.0;
            }
        ])->rowQuantity($rows);
        return $this;
    }

    public function seedAttribute(int $rows = 1): DbSeeder
    {
        $this->seeder->table('film_attribute')->columns([
            'id_film_attribute',
            'name' => $this->faker->name,
            'id_film_attribute_type' => $this->faker->randomElement([1, 2, 3, 4, 5])
        ])->rowQuantity($rows);
        return $this;
    }

    public function seedAttributeValue(int $rows = 1): DbSeeder
    {
        $this->seeder->table('film_attribute_value')->columns([
            'id_film_attribute_value',
            'id_film' => $this->generator->relation('film', 'id_film'),
            'id_film_attribute' => $this->generator->relation('film_attribute', 'id_film_attribute'),
            'bool_value' => $this->faker->boolean(),
            'int_value' => $this->faker->randomNumber(),
            'text_value' => $this->faker->text(),
            'date_value' => $this->faker->date(),
        ])->rowQuantity($rows);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function fill(): void
    {
        $this->seeder->refill();
    }

    public function seedAttributeType(): DbSeeder
    {
        $this->seeder->table('film_attribute_type')
            ->data([
                [1, 'Целое', 'integer'],
                [2, 'Текст', 'text'],
                [3, 'Дата', 'timestamp'],
                [4, 'Да/Нет', 'boolean'],
                [5, 'Раб.Дата', 'timestamp']
            ], ['id_film_attribute_type', 'name', 'type']);
        return $this;
    }
}
