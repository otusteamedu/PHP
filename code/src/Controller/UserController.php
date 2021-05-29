<?php


namespace App\Controller;


use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends AbstractController
{
    const SUCCESS_MESSAGE = 'Спасибо за обращение. Результат будет выслан на Ваш электронный адрес.';
    const ERROR_MESSAGE = 'Сервис временно недоступен. Попробуйте позднее.';
    const ERROR_VALIDATION_MESSAGE = 'Начальная дата больше конечной даты.';


    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function profile(Request $request, Response $response): Response
    {
        return $this->render($response, 'user/profile.php', [
            'user' => $this->user
        ]);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function bankAccount(Request $request, Response $response): Response
    {
        $firstOperation = $this->bankOperation->getUserFirstOperation($this->user);

        if ($request->getMethod() === 'POST') {
            list ($dateStart, $dateEnd) = $this->getRequestData($request);

            if (!$this->validate($dateStart, $dateEnd)) {
                $error = self::ERROR_VALIDATION_MESSAGE;
            } elseif ($this->bankOperation->getUserOperations($this->user, $dateStart, $dateEnd)) {
                $success = self::SUCCESS_MESSAGE;
            } else {
                $error = self::ERROR_MESSAGE;
            }
        }

        return $this->render($response, 'user/bank-operation.php', [
            'dateStart' => $firstOperation ? $firstOperation->getCreatedAt()->format('Y-m-d') : date('Y-m-d'),
            'dateEnd' => date('Y-m-d'),
            'error' => $error ?? null,
            'success' => $success ?? null,
        ]);
    }

    private function validate(DateTime $dateStart, DateTime $dateEnd): bool
    {
        if ($dateStart > $dateEnd) {
            return false;
        }

        return true;
    }

    /**
     * @throws \Exception
     */
    private function getRequestData($request): array
    {
        list ($start, $end) = array_values($request->getParsedBody());
        $dateStart = new DateTime($start);
        $dateEnd = new DateTime($end);

        return [$dateStart, $dateEnd];
    }
}
