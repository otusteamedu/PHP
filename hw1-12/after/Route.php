<?php

class Route
{
    /**
     * @var Klein
     */
    private Klein $router;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->router = new Klein();
    }

    public function init(): void
    {
        $repository = new ElasticSearchRepository();
        $youtubeApiYoutubeApiService = new YoutubeApiService();
        $statisticsYoutubeApiService = new StatisticsYoutubeApiService($repository);

        $this->router->respond(
            'GET',
            '/grub',
            static fn() =>
            (new YoutubeController($repository, $youtubeApiYoutubeApiService, $statisticsYoutubeApiService))->grub());

        $this->router->respond(
            'GET',
            '/statistics-channel-videos',
            static fn() =>
            (new YoutubeController($repository, $youtubeApiYoutubeApiService, $statisticsYoutubeApiService))->getStatisticsChannelVideos());

        $this->router->respond(
            'DELETE',
            '/deleting-indexes',
            static fn() =>
            (new YoutubeController($repository, $youtubeApiYoutubeApiService, $statisticsYoutubeApiService))->delete());

        $this->router->dispatch();
    }
}