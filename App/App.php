<?php


namespace App;


use App\Amqp\Connection;
use App\Console\Command;
use App\Controllers\FormController;
use App\Shop\Adapters\IceCreamAdapter;
use App\Shop\Factory\Interfaces\FastFoodFactory;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class App
{

    private $responseCode = 200;

    /**
     * @return string
     * @throws Console\Exceptions\CommandNotFound
     */
    public function run()
    {
        $this->loadEnv();
        $this->bind();
        Command::exec();
        $this->routes();

        return (new Router())->route();
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

        Container::bind(AMQPStreamConnection::class, fn() => Connection::create());
    }


    public function routes()
    {
        Router::get('^/$', fn() => 'Hello!');
        Router::get('^/form/$', fn() => (new FormController())->get());
        Router::post('^/form/$', fn() => (new FormController())->post());
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
                'RABBIT_HOST',
                'RABBIT_PORT',
                'RABBIT_USER',
                'RABBIT_PASSWORD',
            ])->immutable()->make();
        Dotenv::create($repository, __DIR__ . '/../docker')->load();
    }
}