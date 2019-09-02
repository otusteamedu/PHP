<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */


namespace APP;

class Router
{
    public const MALFORMED_REQUEST = 'malformed_request';
    public const CORRUPTED_PARAMETER = 'corrupted_parameter';
    public const PROPER_REQUEST = 'proper_request';

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRoute(): string
    {
        $body = $this->request->getBody();

        if ($body === null) {
            return self::MALFORMED_REQUEST;
        }

        if (!StringValidator::isAllBracketsClosedProperly($body['string'])) {
            return self::CORRUPTED_PARAMETER;
        }

        return self::PROPER_REQUEST;
    }
}