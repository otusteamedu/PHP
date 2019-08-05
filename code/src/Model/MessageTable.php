<?php

namespace crazydope\theater\Model;

use crazydope\theater\database\TableGatewayInterface;
use Webpatser\Uuid\Uuid;

class MessageTable implements MessageTableInterface
{
    /**
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    public function __construct(TableGatewayInterface $table)
    {
        $this->tableGateway = $table;
    }

    public function insert(MessageInterface $message): string
    {
        if($message->getId() === null) {
            $uuid = Uuid::generate();
            $message->setId($uuid->bytes);
        }

        $this->tableGateway->insert($message->toArray());
        return $uuid->string;
    }

    public function get(string $uuid): ?MessageInterface
    {
        $id = Uuid::import($uuid)->bytes;
        $rowSet = $this->tableGateway->select(['id'=>$id]);
        if ($rowSet->count() > 0) {
            return $rowSet->current();
        }
        return null;
    }

    public function update(MessageInterface $message): int
    {
        $id = Uuid::import($message->getId())->bytes;
        return $this->tableGateway->update(
            ['answer'=>$message->getAnswer(),'status'=>$message->getStatus()],
            ['id'=>Uuid::import($message->getId())->bytes]
        );
    }

    public function delete(string $uuid): int
    {
        $id = Uuid::import($uuid)->bytes;
        return $this->tableGateway->delete(['id'=>$id]);
    }
}