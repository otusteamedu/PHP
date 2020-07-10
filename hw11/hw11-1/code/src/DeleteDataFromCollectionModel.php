<?php


namespace YoutubeApp;


use MongoDB\Collection;

class DeleteDataFromCollectionModel extends ChannelsModel
{
    protected string $documentId;

    public function deleteCollection(Collection $collection): bool
    {
        $result = $collection->drop();
        return isset($result);
    }

    public function deleteDocumentById(Collection $collection, string $documentId): int
    {
        $result = $collection->deleteOne(['_id' => $documentId]);
        return $result->getDeletedCount();
    }

}