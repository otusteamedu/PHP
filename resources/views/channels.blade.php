@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Channels <small>({{ $channels->count() }})</small>
            </div>
            <div class="card-body">
                <form action="{{ url('/channels/search') }}" method="get">
                    <div class="form-group">
                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            placeholder="Search..."
                            value="{{ request('q') }}"
                        />
                    </div>
                </form>
                @forelse ($channels as $channel)
                    <article class="mb-3 mb-1 border-bottom">

                        <div class="container m-0">
                            <div class="row">
                                <div class="col-sm-3 p-0">
                                    <h2><a href="{{$channel['url']}}" class="link-secondary">{{$channel['name']}}</a>
                                    </h2>
                                </div>
                                <div class="col-sm">
                                    <div class="d-flex flex-row bd-highlight">

                                        <div
                                            class="border border-primary rounded p-1 mt-1 mr-0  mb-1 bg-dark text-white vertical-center">
                                            Videos: <span
                                                class="badge bg-primary pt-1">{{$channel['total_views']}}</span>
                                        </div>
                                        <div
                                            class="border border-primary rounded p-1 m-1 bg-dark text-white vertical-center">
                                            Likes: <span
                                                class="badge bg-success pt-1">{{$channel['total_likes']}}</span>
                                        </div>
                                        <div
                                            class="border border-primary rounded p-1 m-1 bg-dark text-white vertical-center">
                                            Dislikes: <span
                                                class="badge bg-danger pt-1">{{$channel['total_dislikes']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="m-0">{{ $channel['description'] }}</p>
                        <div class="mb-2 mt-2">
                            @foreach ($channel['tags'] as $tag)
                                <span class="badge badge-light">{{ $tag}}</span>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <p>No channels found</p>
                @endforelse
            </div>
        </div>
    </div>
@stop
