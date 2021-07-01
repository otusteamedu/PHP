<?php


namespace App\Observers\Traits;


use App\Models\Channel;
use Elasticsearch\Client;

trait HasIndexElasticsearch
{
    private Client $elasticsearch;

    /**
     * HasIndexElasticsearch constructor.
     * @param Client $elasticsearch
     */
    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Изменяет индекс в Эластике при записи в базу данных
     * @param Channel $channel
     */
    public function onSave(Channel $channel): void
    {
        $params = array_merge(
            $this->generateElasticsearchParams($channel),
            ['body'  => $channel->toSearchArray()],
        );
        if (!$channel->videos->isEmpty()) {
            foreach ($channel->videos as $video) {
                $this->elasticsearch->index(
                    array_merge(
                        $params,
                        ['id' => $video->getAttribute('youtube_video_id')],
                    )
                );
            }
        } else {
            $this->elasticsearch->index($params);
        }
    }

    /**
     * Удаляет все записи для Канала в индексе
     * @param Channel $channel
     */
    public function onDelete(Channel $channel): void
    {
        $params = $this->generateElasticsearchParams($channel);
        if (!$channel->videos->isEmpty()) {
            foreach ($channel->videos as $video) {
                $this->elasticsearch->delete(
                    array_merge(
                        $params,
                        ['id' => $video->getAttribute('youtube_video_id')],
                    )
                );
            }
        } else {
            $this->elasticsearch->delete($params);
        }
    }

    /**
     * Возвращает параметры для работы с индексом Эластики
     * @param Channel $channel
     * @return array
     */
    private function generateElasticsearchParams(Channel $channel): array
    {
        return [
            'index' => $channel->getSearchIndex(),
            'type'  => $channel->getSearchType(),
            'id'    => $channel->getSearchId(),
        ];

    }

}
