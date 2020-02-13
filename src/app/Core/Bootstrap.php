<?php

namespace App\Core;

use PDO;
use PDOException;

class Bootstrap
{
    private Environment $environment;
    private PDO $pdo;
    private Request $request;
    private Response $response;

    /**
     * AppContainer constructor.
     * @param Environment $env
     * @param string|null $requestStr
     */
    public function __construct(Environment $env, ?string $requestStr = null)
    {
        $this->environment = $env;
        $this->request = new Request($requestStr);
        $this->response = new Response();
        try {
            $connector = $env->getPdoConnector();
            $this->pdo = new PDO(
                $connector->getDsn(),
                $connector->getUser(),
                $connector->getPass(),
                $connector->getParameters()
            );
        } catch (PDOException $e) {
            // todo: перенести обработку ошибок
            $this->response->setBody(
                $env->isProduction() ?
                    'connection to database could not be established' :
                    $e->getMessage()
            )->flush(500);
        }
    }

    public function run()
    {
        $processor = new Processor($this);
        $processor->validateRequest();
        $processor->execute();
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * @param Environment $environment
     * @return Bootstrap
     */
    public function setEnvironment(Environment $environment): Bootstrap
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     * @return Bootstrap
     */
    public function setPdo(PDO $pdo): Bootstrap
    {
        $this->pdo = $pdo;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return Bootstrap
     */
    public function setRequest(Request $request): Bootstrap
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return Bootstrap
     */
    public function setResponse(Response $response): Bootstrap
    {
        $this->response = $response;
        return $this;
    }
}