<?php


namespace App\Command;


use App\Entity\Airline;
use App\Utils\Transliterator\TransliteratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAirlineCommand extends Command
{
    const MAX_COUNT = 20;

    private EntityManagerInterface $entityManager;
    private Generator $faker;
    private TransliteratorInterface $transliterator;

    /**
     * CreateUsersCommand constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, Generator $faker, TransliteratorInterface $transliterator)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->faker = $faker;
        $this->transliterator = $transliterator;
    }


    protected function configure(): void
    {
        $this
            ->setName('airlines:create')
            ->setDescription('Создает фейковые авиакомпании');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $counter = 0;
        $companies = $this->getCompanies();

        for ($i = 0; $i < self::MAX_COUNT; $i++) {
            list (, $title) = explode(' ', $this->faker->unique(true)->company);
            $abbreviation = $this->getAbbreviation($title);

            if (
                array_key_exists($abbreviation, $companies) ||
                array_search($title, $companies)
            ) {
                continue;
            }

            $airline = new Airline();
            $airline
                ->setTitle($title)
                ->setDescription($this->faker->realText())
                ->setAbbreviation($abbreviation);

            $this->entityManager->persist($airline);

            $companies[$abbreviation] = $title;
            $counter++;
        }

        $this->entityManager->flush();

        echo 'Created ' . $counter . ' airlines!', PHP_EOL;
        return Command::SUCCESS;
    }

    private function getAbbreviation(string $company): string
    {
        $companyTranslit = $this->transliterator->translit($company);
        return substr(strtoupper($companyTranslit), 0, 3);
    }

    private function getCompanies(): array
    {
        $query = $this->entityManager->createQuery('SELECT a.abbreviation, a.title FROM App\Entity\Airline a');
        $result = $query->getResult();

        $data = [];
        foreach ($result as $r) {
            list ($key, $value) = array_values($r);
            $data[$key] = $value;
        }

        return $data;

    }

}
