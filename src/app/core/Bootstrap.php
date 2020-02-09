<?php

namespace Core;

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
     */
    public function __construct(Environment $env)
    {
        $this->environment = $env;
        $this->request = new Request();
        $this->response = new Response();
        try {
            $this->pdo = new PDO($env->getDbDsn());
        } catch (PDOException $e) {
            // todo: исключения должны обрабатываться в другом слое
            $this->response->setBody(
                'connection to database could not be established'
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