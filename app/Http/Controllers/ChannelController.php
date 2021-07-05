<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Services\Youtube\ChannelService;
use App\Services\Youtube\ChannelStatisticService;
use App\Services\Youtube\Repositories\WriteChannelRepository;
use App\Services\Youtube\VideoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    /**
     * Хранит объект класса ChannelService
     * @var ChannelService
     */
    private ChannelService $channelService;

    /**
     * Хранит объект класса VideoService
     * @var VideoService
     */
    private VideoService $videoService;

    /**
     * Хранит объект класса ChannelStatisticService
     * @var ChannelStatisticService
     */
    private ChannelStatisticService $channelStatisticService;

    /**
     * Хранит объект класса WriteChannelRepository
     * @var WriteChannelRepository
     */
    private WriteChannelRepository $writeChannelRepository;

    /**
     * ChannelController constructor.
     * Использует следующие сервисы
     * @param ChannelService $channelService
     * @param VideoService $videoService
     * @param ChannelStatisticService $channelStatisticService
     * @param WriteChannelRepository $writeChannelRepository
     */
    public function __construct(
        ChannelService $channelService,
        VideoService $videoService,
        ChannelStatisticService $channelStatisticService,
        WriteChannelRepository $writeChannelRepository)
    {
        $this->channelService = $channelService;
        $this->videoService = $videoService;
        $this->channelStatisticService = $channelStatisticService;
        $this->writeChannelRepository = $writeChannelRepository;
    }


    public function index(Request $request)
    {
        $limit = 1000;
        $search = $request->get('q', '') ?? '';
        $offset = $request->get('page', 0) * $limit;
        $channels = $this->channelService->search(
            $search,
            $limit,
            $offset
        );
        view::share([
            'channels' => $channels,
            'search' => $search,
        ]);
        return view('channels.index');
    }

    public function top(Request $request)
    {
        $number = $request->get('number') ?? 10;
        $channels = $this->channelStatisticService->getTopChannels($number);
        view::share([
            'channels' => $channels,
        ]);
        return view('channels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $this->writeChannelRepository->create($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function show(Request $request, int $id)
    {
        $channel = $this->channelService->getChannelsById($id);

        $channel->likes = $this->channelService->getLikesCountForChannel($id);
        $channel->dislikes = $this->channelService->getDislikesCountForChannel($id);
        $channel->comments = $this->channelService->getCommentsCountForChannel($id);
        $channel->views = $this->channelService->getViewsCountForChannel($id);
        $videos = $channel->videos;
        View::share([
            'channel' => $channel,
            'videos' => $videos,
        ]);
        return view('channels.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return Response
     */
    public function edit(Channel $channel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return Response
     */
    public function update(Request $request, Channel $channel)
    {
        $id = ($request->get('id'));
        $channel = $request->all();
        $this->writeChannelRepository->update($id, $channel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return Response
     */
    public function destroy(Channel $channel)
    {
        //
    }

    /**
     * Удаляет требуемую запись из базы
     *
     * @param Request $request
     * @param Channel $channel
     */
    public function delete(Request $request, Channel $channel)
    {
        $id = ($request->get('id'));
        $this->writeChannelRepository->delete($id);
    }
}
