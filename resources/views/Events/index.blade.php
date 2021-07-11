@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @include('Events.blocks.search.index')
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            @include('Events.blocks.header.index')
            <div class="card-body">
                @include('Events.blocks.list.index')
            </div>
        </div>
    </div>
@stop
