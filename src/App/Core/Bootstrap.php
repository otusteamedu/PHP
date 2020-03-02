<?php

namespace App\Core;

use PDO;
use PDOException;

class Bootstrap
{
    private PDO $pdo;
    private ClientRequest $request;
    private ClientResponse $response;

    /**
     * AppContainer constructor.
     */
    public function __construct()
    {
        $this->request = ClientRequest::getFromHttp();
        $this->response = new ClientResponse();
        $env = new Environment();
        try {
            $connector = $env->getPdoConnector();
            $this->pdo = new PDO(
                $connector->getDsn(),
                $connector->getUser(),
                $connector->getPass(),
                $connector->getParameters()
            );
        } catch (PDOException $e) {
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
     * @return ClientRequest
     */
    public function getRequest(): ClientRequest
    {
        return $this->request;
    }

    /**
     * @param ClientRequest $request
     * @return Bootstrap
     */
    public function setRequest(ClientRequest $request): Bootstrap
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ClientResponse
     */
    public function getResponse(): ClientResponse
    {
        return $this->response;
    }

    /**
     * @param ClientResponse $response
     * @return Bootstrap
     */
    public function setResponse(ClientResponse $response): Bootstrap
    {
        $this->response = $response;
        return $this;
    }
}