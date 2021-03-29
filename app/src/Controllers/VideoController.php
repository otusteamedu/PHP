<?php


namespace App\Controllers;


use App\Core\Request;
use App\Repositories\Video\VideoRepository;
use App\Services\ServiceContainer\AppServiceContainer;

class VideoController extends BaseController
{
    private VideoRepository $videoRepository;

    public function __construct()
    {
        $this->videoRepository = AppServiceContainer::getInstance()->resolve(VideoRepository::class);
    }

    public function index()
    {
        $request = Request::getInstance();
        $query = $request->get('query', '');

        $this->title = 'Search videos';
        $this->content = $this->renderView('/pages/videos/index', [
            'videos' => $this->videoRepository->withChannel()->search($query),
            'query' => $query,
        ]);

        return $this->viewResponse();
    }
}