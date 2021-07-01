<?php


namespace App\Models\Traits;


/**
 * Traits HasSearch
 * @package App\Models\Traits
 */
trait HasSearch
{
    /**
     * Возвращает название индекса
     * @return string
     */
    public function getSearchIndex(): string
    {
        return $this->getTable() . '_index';
    }

    /**
     * Возвращает тип индекса
     * @return string
     */
    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable() . '_index';
    }

    /**
     * Возвращает Id для работы в индексе ()
     * @return string
     */
    public function getSearchId(): string
    {
        return $this->getAttribute('youtube_video_id') ?? 'NoVideos_'.$this->getAttribute('youtube_channel_id');
    }

    /**
     * Возвращает данные объекта в виде массива
     * @return array
     */
    public function toSearchArray(): array
    {
        return $this->toArray();
    }

}
