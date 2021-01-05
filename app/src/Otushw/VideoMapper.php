<?php


namespace Otushw;


use Otushw\DBSystem\NoSQLDAO;

class VideoMapper
{
    /**
     * @var NoSQLDAO
     */
    private $db;

    /**
     * @param $db
     */
    public function __construct(NoSQLDAO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $id
     *
     * @return mixed
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
                $result['dislikeCount'],
                $result['commentCount']
            );
        }
        return false;
    }

    /**
     * @param array $source
     *
     * @return mixed
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
                $source['dislikeCount'],
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
}