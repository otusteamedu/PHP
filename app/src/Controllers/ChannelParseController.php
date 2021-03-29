<?php


namespace App\Controllers;


use App\Core\Request;
use App\Services\Channel\ParseChannelService;
use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;

class ChannelParseController extends BaseController
{
    public function index()
    {
        $this->title = 'Index videos from youtube';
        $this->content = $this->renderView('/pages/channels/parse/index');

        return $this->viewResponse();
    }

    /**
     * @throws YouTubeApiBadResponseException
     */
    public function store(): void
    {
        $request = Request::getInstance();
        $keyword = $request->get('keyword');

        $parseChannelService = new ParseChannelService();
        $parseChannelService->execute($keyword);

        $this->redirect('channels');
    }
}