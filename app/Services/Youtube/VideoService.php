<?php


namespace App\Services\Youtube;


use App\Models\Video;
use App\Services\Youtube\Repositories\SearchVideoRepository;
use App\Services\Youtube\Repositories\WriteVideoRepository;
use Illuminate\Support\Collection;

/**
 * Class VideoService
 * @package App\Services\Youtube
 */
class VideoService
{
    /**
     * @var SearchVideoRepository
     */
    private SearchVideoRepository $searchVideoRepository;

    /**
     * @var WriteVideoRepository
     */
    private WriteVideoRepository $writeVideoRepository;

    public function __construct(
        SearchVideoRepository  $searchVideoRepository,
        WriteVideoRepository  $writeVideoRepository
    )
    {
        $this->searchVideoRepository = $searchVideoRepository;
        $this->writeVideoRepository = $writeVideoRepository;
    }
    public function search(string $q, int $limit, int $offset): Collection
    {
        return $this->searchVideoRepository->search($q, $limit, $offset);
    }

    public function getLikesCountForChannel(int $channelId): Collection
    {
        return $this->searchVideoRepository->getLikesCountForChannel($channelId);
    }

    public function getDislikesCountForChannel(int $channelId): Collection
    {
        return $this->searchVideoRepository->getDislikesCountForChannel($channelId);
    }

    public function getChannelsVideo(int $channelId): Collection
    {
        return $this->searchVideoRepository->getChannelsVideo($channelId);
    }


    public function create(array $data): int
    {
        return $this->writeVideoRepository->create($data);
    }

    public function update(int $id, array $data): void
    {
        $this->writeVideoRepository->update($id, $data);
    }

    public function delete(int $id)    : int
    {
        return $this->writeVideoRepository->delete($id);
    }
}
