<?php


namespace Otushw;


use Otushw\DBSystem\NoSQLDAO;

class VideoMapper
{
    const SIZE_BUTCH = 3;

    /**
     * @var NoSQLDAO
     */
    private NoSQLDAO $db;

    /**
     * @param NoSQLDAO $db
     */
    public function __construct(NoSQLDAO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $id
     *
     * @return Video|false
     */
    public function findById(string $id)
    {
        $result = $this->db->read($id);
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
        return false;
    }

    /**
     * @param array $source
     *
     * @return Video|false
     */
    public function insert(array $source)
    {
        $result = $this->db->create($source);
        if (!empty($result)) {
            return new Video(
                $source['id'],
                $source['title'],
                $source['viewCount'],
                $source['likeCount'],
                $source['disLikeCount'],
                $source['commentCount']
            );
        }
        return false;
    }

    /**
     * @param Video $video
     *
     * @return bool
     */
    public function update(Video $video): bool
    {
        return $this->db->update(
            $video->getId(),
            [
                'title' => $video->getTitle(),
                'viewCount' => $video->getViewCount(),
                'likeCount' => $video->getLikeCount(),
                'disLikeCount' => $video->getDisLikeCount(),
                'commentCount' => $video->getCommentCount()
            ]
        );
    }

    /**
     * @param Video $video
     *
     * @return bool
     */
    public function delete(Video $video): bool
    {
        return $this->db->delete($video->getId());
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = [];
        $offset = 0;
        while ($rows = $this->db->getItems(self::SIZE_BUTCH, $offset)) {
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
        return (int) $this->db->getSumField('likeCount');
    }

    /**
     * @return int
     */
    public function getSumDisLikeCount(): int
    {
        return (int) $this->db->getSumField('disLikeCount');
    }
}
