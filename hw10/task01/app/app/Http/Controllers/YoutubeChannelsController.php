<?php

namespace App\Http\Controllers;

use App\YoutubeChannel;
use Illuminate\Http\Request;

class YoutubeChannelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('youtube_channels.index')->with('channels', YoutubeChannel::orderBy('created_at', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('youtube_channels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'code' => 'required',
        ]);

        $channel = new YoutubeChannel();

        $channel->title = $request->input('title');
        $channel->code = $request->input('code');

        $channel->save();

        return redirect('/')->with('success', 'Channel added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('youtube_channels.show')->with('channel', YoutubeChannel::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('youtube_channels.edit')->with('channel', YoutubeChannel::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'code' => 'required',
        ]);

        $channel = YoutubeChannel::find($id);

        $channel->title = $request->input('title');
        $channel->code = $request->input('code');

        $channel->save();

        return redirect('/')->with('success', 'Channel Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $channel = YoutubeChannel::find($id);
        $channel->delete();

        return redirect('/')->with('success', 'Channel Deleted');
    }
}
