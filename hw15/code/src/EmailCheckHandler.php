<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

use APP\HTTP\Request;
use APP\HTTP\Response;
use APP\Validator\EmailAddressValidator;

class EmailCheckHandler
{
    public const PARAMETER_ACTION = 'action';
    public const PARAMETER_ACTION_CHECK_EMAIL = 'check_email';
    public const PARAMETER_EMAIL = 'email';
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function run(): void
    {
        $response = new Response();

        if ($this->getAction() === self::PARAMETER_ACTION_CHECK_EMAIL && $this->getEmail() !== null) {
            $response->setResponse($this->getResult());
            $response->addCode(200);
        } else {
            $response->setResponse($this->getErrorResult());
            $response->addCode(400);
        }

        $response->send();
    }

    private function getResult(): string
    {
        $validator = new EmailAddressValidator($this->getEmail());
        $result = ['IsEmailValid' => $validator->isValid()];
        return json_encode($result);
    }

    private function getErrorResult(): string
    {
        $result = ['Error' => "Invalid Request"];
        return json_encode($result);
    }

    private function getAction(): ?string
    {
        return $this->getParameter(self::PARAMETER_ACTION);
    }

    private function getEmail(): ?string
    {
        return $this->getParameter(self::PARAMETER_EMAIL);
    }

    private function getParameter(string $parameter): ?string
    {
        $body = $this->request->getBody();
        return $body[$parameter] ?? null;
    }
}