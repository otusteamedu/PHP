<?php


namespace Otushw;

class VideoMapper
{
    const SIZE_BUTCH = 3;

    /**
     * @var StorageInterface
     */
    private StorageInterface $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $id
     *
     * @return Video
     */
    public function findById(string $id): ?Video
    {
        $result = $this->storage->read($id);
        if (!empty($result)) {
            return new Video(
                $id,
                $result['title'],
                $result['viewCount'],
                $result['likeCount'],
                $result['disLikeCount'],
                $result['commentCount']
            );
        }
        return null;
    }

    /**
     * @param VideoDTO $source
     *
     * @return Video
     */
    public function insert(VideoDTO $source): ?Video
    {
        $result = $this->storage->create($source);
        if (!empty($result)) {
            return new Video(
                $source->id,
                $source->title,
                $source->viewCount,
                $source->likeCount,
                $source->disLikeCount,
                $source->commentCount
            );
        }
        return null;
    }

    /**
     * @param Video $video
     *
     * @return bool
     */
    public function update(Video $video): bool
    {
        return $this->storage->update(
            $video->getId(),
            new VideoDTO(
                $video->getId(),
                $video->getTitle(),
                $video->getViewCount(),
                $video->getLikeCount(),
                $video->getDisLikeCount(),
                $video->getCommentCount()
            )
        );
    }

    /**
     * @param Video $video
     *
     * @return bool
     */
    public function delete(Video $video): bool
    {
        return $this->storage->delete($video->getId());
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = [];
        $offset = 0;
        while ($rows = $this->storage->getItems(self::SIZE_BUTCH, $offset)) {
            $result = array_merge($result, $rows);
            $offset += self::SIZE_BUTCH;
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getSumLikeCount(): int
    {
        return (int) $this->storage->getSumField('likeCount');
    }

    /**
     * @return int
     */
    public function getSumDisLikeCount(): int
    {
        return (int) $this->storage->getSumField('disLikeCount');
    }
}
