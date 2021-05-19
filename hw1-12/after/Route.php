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

        foreach (Config::ROUTES as $route) {
            $this->router->respond(
                $route['method'],
                $route['path'],
                static fn() => (new YoutubeController(
                    $repository,
                    $youtubeApiYoutubeApiService,
                    $statisticsYoutubeApiService)
                )->$route['function']);
        }

        $this->router->dispatch();
    }
}