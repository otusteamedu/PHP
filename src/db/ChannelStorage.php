<?php

namespace crazydope\youtube\db;

use crazydope\youtube\Channel;
use crazydope\youtube\ChannelInterface;
use crazydope\youtube\db\adapter\MongoAdapterInterface;
use MongoDB\BSON\ObjectId;
use MongoDB\Model\BSONDocument;

class ChannelStorage extends AbstractStorage implements GetChannelInterface
{
    /**
     * ChanelStorage constructor.
     * @param MongoAdapterInterface $mongo
     * @param string $collection
     */
    public function __construct(MongoAdapterInterface $mongo, string $collection)
    {
        $this->adapter = $mongo;
        $this->collection = $collection;
    }

    /**
     * @param string $id
     * @return ChannelInterface
     */
    public function getChannelById(string $id): ?ChannelInterface
    {
        $objectId = new ObjectId($id);
        $data = $this->find(['_id'=>$objectId]);

        if(empty($data)) {
            return null;
        }

        if (!$data[0] instanceof BSONDocument) {
            return null;
        }

        $channel = new Channel();
        $channel->exchangeArray($data[0]->getArrayCopy());
        return $channel;

    }
}