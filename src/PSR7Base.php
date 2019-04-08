<?php

namespace HW7_1;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\TestLogger;

abstract class PSR7Base
{
    /**
     * @var ListValidationWrapper
     */
    protected $validation;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(ListValidationWrapper $validation)
    {
        if (!$validation) {
            $this->validation = new ListValidationWrapper(new ComplexValidation([
                new RegexpValidation(),
                new CheckDNSValidation()
            ]));
        } else {
            $this->validation = $validation;
        }
        $this->logger = new TestLogger();
        $this->validation->setLogger($this->logger);
    }

    /**
     * @param ResponseInterface $response
     * @param array $result
     * @return ResponseInterface
     */
    protected function createResponse(ResponseInterface $response, array $result): ResponseInterface
    {
        $response->withStatus(200)
            ->withHeader('Content-Encoding', 'application/json')
            ->getBody()->write(json_encode($result));
        return $response;
    }
}
