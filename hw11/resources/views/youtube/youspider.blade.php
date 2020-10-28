@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Hi. I am a spider!</h1>
                <form action="POST" class="mt-5" id="getYouTubeLink">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input type="text" name="channel-link" id="channel_link" class="form-control"
                                   placeholder="Введите ссылку на youtube канал"/>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Go</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="form-error-message">
                    Прозошла непредвиденная ошибка, мы уже разбираемся с проблемой. Попробуйте повторить попытку позже.
                    Приносим извинения за доставленные неудобства!
                </div>
                <div id="searchResult"></div>
            </div>
        </div>
    </div>
@endsection
