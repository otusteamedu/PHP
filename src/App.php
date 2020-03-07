<?php

namespace Bjlag;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Router;

class App
{
    /** @var string */
    private $appRoot;

    /** @var \Symfony\Component\Routing\RouterInterface */
    private $router;

    /** @var \Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory */
    private $psrHttpFactory;

    /** @var \Psr\Http\Message\ServerRequestInterface */
    private $request;

    public function __construct()
    {
        $this->appRoot = dirname(__DIR__);

        $fileLocator = new FileLocator([$this->appRoot . '/config']);
        $loader = new YamlFileLoader($fileLocator);

        $this->router = new Router($loader, 'routes.yaml');

        $psr17Factory = new Psr17Factory();
        $this->psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
    }

    public function run(): void
    {
        $symfonyRequest = Request::createFromGlobals();
        $this->request = $this->psrHttpFactory->createRequest($symfonyRequest);

        try {
            $parameters = $this->router->matchRequest($symfonyRequest);

            $controller = $parameters['_controller'];
            $action = $parameters['_action'];

            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = (new $controller())->$action($this->request, $parameters);
        } catch (ResourceNotFoundException $e) {
            $response = $this->createResponseError(Response::HTTP_NOT_FOUND, 'Page not found');
        } catch (InvalidParameterException $e) {
            $response = $this->createResponseError(Response::HTTP_UNPROCESSABLE_ENTITY, "Error: {$e->getMessage()}");
        } catch (\Exception $e) {
            $response = $this->createResponseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'Server error');
        }

        (new HttpFoundationFactory())
            ->createResponse($response)
            ->send();
    }

    /**
     * @param int $code
     * @param string $body
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function createResponseError(int $code, string $body): ResponseInterface
    {
        return $response = (new \Bjlag\Response($code, [], $body))
            ->withServerName($this->request)
            ->get();
    }
}
