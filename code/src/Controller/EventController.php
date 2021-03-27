<?php


namespace App\Controller;


use App\Model\Interfaces\EventInterface;
use App\Services\Exceptions\EventServiceEventNotFoundException;
use App\Services\Exceptions\EventServiceParamsException;
use App\Services\RedisEventService;
use App\Util\TerminalLogger;
use Google\Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventController extends AbstractController
{
    private RedisEventService $service;
    private ?string $error = null;

    /**
     * EventController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->service = new RedisEventService($container);
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, 'event/index.php', [
            'scripts' => ['event']
        ]);
    }

    public function events(Request $request, Response $response): Response
    {
        $events = $this->service->getAll();
        $arrayEvents = array_map(fn($item) => $item->toArray(), $events);
        $response->getBody()->write(json_encode($arrayEvents));
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function event(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        try {
            $event = $this->service->getEvent($data)->toArray();

        } catch (EventServiceEventNotFoundException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($event));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function drop(Request $request, Response $response): Response
    {
        $status = $this->service->deleteEvents();
        $data = $status ? ['status' => 'OK'] : ['status' => 'error'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createEvent(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $event = $this->addEvent($data)->toArray();

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($event));
        return $response
            ->withStatus(201)
            ->withHeader('Content-Type', 'application/json');

    }

    private function addEvent($data): EventInterface
    {
        $param1 = $data['param1'] ? ['param1' => (int)$data['param1']] : [];
        $param2 = $data['param2'] ? ['param2' => (int)$data['param2']] : [];
        $params = array_merge($param1, $param2);

        return $this->service->addEvent(
            (int)$data['priority'],
            $params,
            $data['event']
        );
    }
}

