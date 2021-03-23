@extends('layout')
<div class="row">
    <div class="col col-sm-12">
        <div class="card" style="margin: 100px;">
            <div style="display: flex">
                <div class="col-xl-1 col-md-3 col-sm-4 btn-dark">
                    <a href="/">Add event</a>
                </div>
                <div class="col-xl-1 col-md-3 col-sm-4 btn-info">
                    <a href="/get">Get event</a>
                </div>
                <div class="col-xl-1 col-md-3 col-sm-4 btn-danger">
                    <a href="/flush">Flush redis</a>
                </div>
            </div>
        @include('store.blocks.get')
        </div>
    </div>
</div>
