<?php


namespace App\Command;


use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCitiesCommand extends Command
{
    const CITIES = [
        'Москва', 'Санкт-Петербург', 'Тюмень', 'Новосибирск',
        'Казань', 'Ростов-на-Дону', 'Сочи', 'Гамбург', 'София', 'Париж'
    ];

    private EntityManagerInterface $entityManager;

    /**
     * CreateCitiesCommand constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('cities:create')
            ->setDescription('Создает города');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            foreach (self::CITIES as $key => $name) {
                $city = new City();
                $city->setName($name);

                $this->entityManager->persist($city);
            }

            $this->entityManager->flush();

            echo 'Cities created!', PHP_EOL;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return Command::SUCCESS;
    }


}
