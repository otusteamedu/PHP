<?php

namespace App\Service;

use App\Db\Repository;

/**
 * Class ApiService
 * @package App\Service
 */
class ApiService
{
    private $repository;

    /**
     * ApiService constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @param RabbitService $rabbitService
     * @return string
     */
    public function send(array $data, RabbitService $rabbitService): string
    {
        if (empty($data['message'])) {
            echo $this->getResponse(500, 'No message passed.');
            exit;
        }

        $id = $this->repository->insert($data['message']);
        $rabbitService->publish(md5($id));

        return $this->getResponse(200, md5($id));
    }

    /**
     * @param $data
     * @return string
     */
    public function get($data): string
    {
        if (empty($data['code'])) {
            echo $this->getResponse(500, 'No code passed');
            exit;
        }

        $result = $this->repository->select($data['code']);

        $message = $result['status'] === 1 ? 'Статус: обработано' : 'Статус: не обработано';
        $message .= '<br>Ваш вопрос: ' . $result['question'];
        $message .= '<br>Ответ: ' . $result['answer'];

        return $this->getResponse(200, $message);
    }

    /**
     * @param int $code
     * @param string $message
     * @return string
     */
    public function getResponse(int $code, string $message): string
    {
        return json_encode([
            'code' => $code,
            'status' => $code === 200 ? 'ok' : 'error',
            'message' => $message,
        ]);
    }
}