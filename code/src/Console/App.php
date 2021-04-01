<?php


namespace App\Console;


use App\Model\Airline;
use App\Model\Airplane;
use App\Services\Orm\ModelManager;
use App\Utils\Config;
use phpseclib3\Math\BigInteger\Engines\PHP;
use Psr\Container\ContainerInterface;


class App extends Console
{
    private ContainerInterface $container;
    private ModelManager $mm;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->container = Config::buildContainer();
        $this->mm = $this->container->get(ModelManager::class);

    }

    public function run()
    {
        $cancel = false;

        while(!$cancel) {
            echo 'Airlines (a), Airplanes (p),  выход (q): ';
            $answer = $this->readLine();

            switch($answer) {
                case 'a':
                    $this->showAirlines();
                    break;
                case 'p':
                    $this->showAirplanes();
                    break;
                case 'q':
                default:
                    echo 'Bye bye', PHP_EOL;
                    $cancel = true;
            }
        }
    }

    private function showAirlines()
    {
        echo PHP_EOL, 'Airlines:', PHP_EOL;
        $airlines = $this->mm->getRepository(Airline::class)
            ->findAll();


        foreach ($airlines as $airline) {
            echo "\n***************************\n";
            echo $airline->getName(), '(', $airline->getAbbreviation(), ')', PHP_EOL;
            echo $airline->getDescription(), PHP_EOL;

            echo 'Airplanes:', PHP_EOL;

            $airplanes = $airline->getAirplanes();

            foreach ($airplanes as $airplane) {
                echo self::TAB, $airplane->getName(), PHP_EOL;
            }

        }

        echo PHP_EOL;
    }

    private function showAirplanes()
    {
        echo PHP_EOL, 'Airplanes', PHP_EOL;

        $airplanes = $this->mm->getRepository(Airplane::class)
            ->findAll();
        foreach ($airplanes as $a) {
            echo PHP_EOL, $a->getName(), PHP_EOL;
            echo 'Seats: ', $a->getSeatsCount(), PHP_EOL;
            echo 'Number: ', $a->getNumber(), PHP_EOL;
            echo 'Build data: ', $a->getBuildDate()->format('d.m.Y'),PHP_EOL;
        }

        echo PHP_EOL;
    }
}

