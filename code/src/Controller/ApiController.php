<?php

namespace crazydope\theater\Controller;

use crazydope\theater\Job\QueueInterface;
use crazydope\theater\Model\Message;
use crazydope\theater\Model\MessageTableInterface;

class ApiController
{
    /**
     * @var MessageTableInterface
     */
    protected $table;
    /**
     * @var QueueInterface
     */
    protected $queue;

    public function __construct(MessageTableInterface $table,QueueInterface $queue)
    {
        $this->table = $table;
        $this->queue = $queue;
    }

    /**
     * @param string $uuid
     * @return string
     */
    public function show(string $uuid): string
    {
        $message = $this->table->get($uuid);
        return response()->json([
            'status'=>'ok',
            'result' => $message ? $message->toArray() : null
        ]);
    }
    /**
     * @return string|null
     */
    public function index(): ?string
    {
        $job = null;
        $message = null;
        $callback = static function ($data) use (&$job)
        {
            if($data instanceof \crazydope\theater\Model\JobInterface){
                $job = $data->getValue();
            }
            return true;
        };

        $this->queue->consume($callback);

        if($job){
            $message = $this->table->get($job);
        }

        return response()->json([
            'status'=>'ok',
            'result' => $message ? $message->toArray() : $job
        ]);
    }

    /**
     * @return string|null
     * @throws \Exception
     */
    public function store(): ?string
    {
        $data = inputValidator();
        $message = new Message();
        $message
            ->setMessage($data['message'])
            ->setStatus(Message::STATUS_IN_PROGRESS)
            ->setType($data['type']);

        $id = $this->table->insert($message);

        $this->queue->publish($id);

        return response()->json([
            'status' => 'ok',
            'result' => $id
        ]);
    }

    /**
     * @param string $uuid
     * @return string|null
     * @throws \Exception
     */
    public function update(string $uuid): ?string
    {
        $data = inputValidator();
        $message = new Message();
        $message
            ->setId($uuid)
            ->setAnswer($data['answer'])
            ->setStatus($data['status']);

        return response()->json([
            'status' => 'ok',
            'result' => $this->table->update($message)
        ]);
    }
    /**
     * @param string $uuid
     * @return string|null
     */
    public function destroy(string $uuid): ?string
    {
        return response()->json([
            'status' => 'ok',
            'result' => $this->table->delete($uuid)
        ]);
    }
}