<?php

namespace crazydope\theater\Model;

use Webpatser\Uuid\Uuid;

class Message implements MessageInterface
{
    /**
     * @var null | string
     */
    protected $id;
    /**
     * @var null | string
     */
    protected $message;
    /**
     * @var null| string
     */
    protected $answer;
    /**
     * @var null | integer
     */
    protected $type;
    /**
     * @var null | integer
     */
    protected $status;

    public function exchangeArray(array $data): void
    {
        $this->id = $data['id'] ? Uuid::import($data['id'])->string : null;
        $this->message = $data['message'] ?? null;
        $this->answer = $data['answer'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->status = $data['status'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return MessageInterface
     */
    public function setId(?string $id): MessageInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return MessageInterface
     */
    public function setMessage(?string $message): MessageInterface
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     * @return MessageInterface
     */
    public function setType(?int $type): MessageInterface
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return MessageInterface
     */
    public function setStatus(?int $status): MessageInterface
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param string|null $answer
     * @return MessageInterface
     */
    public function setAnswer(?string $answer): MessageInterface
    {
        $this->answer = $answer;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id'=>$this->id,
            'message'=>$this->message,
            'answer'=>$this->answer,
            'type'=>$this->type,
            'status'=> $this->status,
        ];
    }
}