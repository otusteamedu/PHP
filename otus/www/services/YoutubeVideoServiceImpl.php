<?php

namespace Services;

use Classes\Dto\VideoDto;
use Classes\Models\YoutubeVideo;
use Classes\Repositories\YoutubeVideoRepositoryImpl;

class YoutubeVideoServiceImpl implements YoutubeVideoServiceInterface
{
    private $youtubeVideoRepository;

    public function __construct(YoutubeVideoRepositoryImpl $youtubeVideoRepository)
    {
        $this->youtubeVideoRepository = $youtubeVideoRepository;
    }


    public function create(VideoDto $videoDto)
    {
        $model = new YoutubeVideo();
        $model->id = $videoDto->videoId;
        $model->name = $videoDto->videoName;
        $model->chanelId = $videoDto->chanelId;
        $model->likeCount = $videoDto->videoLikeCount;
        $model->dislikeCount = $videoDto->videoDislikeCount;

        $this->youtubeVideoRepository->create($model);
    }

    public function deleteById(string $id)
    {
        $this->youtubeVideoRepository->deleteById($id);
    }
}
