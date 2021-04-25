<?php


namespace App;


use App\Console\Command;
use App\Shop\Adapters\IceCreamAdapter;
use App\Shop\Factory\Interfaces\FastFoodFactory;
use App\Shop\Observers\OrderObserver;
use App\Shop\Order;
use App\Shop\OrderController;
use App\Shop\OrderStatusNotify;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;

class App
{

    private $responseCode = 200;
    private $response = null;

    /**
     * @return string
     * @throws Console\Exceptions\CommandNotFound
     */
    public function run()
    {
        $this->loadEnv();
        $this->bind();
        Command::exec();

        return $this->response;
    }

    private function bind()
    {
        Container::bind(FastFoodFactory::class, static function (Container $c, $args) {
            $factoryClass = '\\' . __NAMESPACE__ . '\\Shop\\Factory\\' . ucfirst($args['food']) . 'Factory';
            return $c->get($factoryClass);
        });
        Container::bind('food', static function (Container $c, $args) {
            if ($args['food'] === 'ice-cream') {
                return $c->get(IceCreamAdapter::class);
            }
            /**@var FastFoodFactory $factory */
            $factory = $c->get(FastFoodFactory::class, $args);
            $method = 'create' . ucfirst($args['type']) . 'Food';
            if (method_exists($factory, $method)) {
                return $factory->$method();
            }
            return null;
        });
    }

    private function loadEnv()
    {
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(EnvConstAdapter::class)
            ->addWriter(PutenvAdapter::class)
            ->allowList([
                'DB_DRIVER',
                'DB_HOST',
                'DB_NAME',
                'DB_USER',
                'DB_PORT',
                'DB_PASSWORD',
            ])->immutable()->make();
        Dotenv::create($repository, __DIR__ . '/../docker')->load();
    }
}