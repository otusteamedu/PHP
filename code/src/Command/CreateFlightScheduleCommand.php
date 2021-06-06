<?php


namespace App\Command;


use App\Entity\Airline;
use App\Entity\City;
use App\Entity\FlightSchedule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateFlightScheduleCommand extends Command
{
    private EntityManagerInterface $entityManager;

    /**
     * CreateFlightScheduleCommand constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setName('flight-schedule:create')
            ->setDescription('Create flights');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $airlines = $this->entityManager
                ->getRepository(Airline::class)
                ->findBy([], null, 3);

            $departure = $this->getCityByName('Москва');
            $arrival = $this->getCityByName('Сочи');

            $hour = 7;

            /** @var Airline $airline */
            foreach ($airlines as $airline) {
                $hour += 3;

                $date = new \DateTime;
                $date->setTime($hour, 30);

                $flight = new FlightSchedule();
                $flight
                    ->setAirline($airline)
                    ->setDeparture($departure)
                    ->setArrival($arrival)
                    ->setDepartureTime($date);

                $this->entityManager->persist($flight);
            }

            $this->entityManager->flush();

            echo 'FlightScheduled created!', PHP_EOL;


        } catch (\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
            echo 'File: ' . $e->getFile() . ':' . $e->getLine(), PHP_EOL;
        }

        return Command::SUCCESS;
    }

    private function getCityByName(string $name): ?City
    {
        /** @var City $city */
        $city = $this->entityManager
            ->getRepository(City::class)
            ->findOneBy(['name' => $name]);

        return $city;

    }


}
