<div class="card">
    <div class="card-body">
        <form class="" action="/get">
            @csrf
            <div class="row">
                <div class="col col-md-6">
                    <input type="text" class="form-control" name="q" value="{{ $search }}" placeholder="Поиск канала">
                </div>
                <div class="col col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">Поиск</button>
                </div>
                <div class="col col-md-3">
                    <a href="{{ route('getTop') }}" class="btn btn-outline-danger"> Посмотреть топ каналов </a>
                </div>
            </div>
        </form>

        @if (!empty($channel))
            <p>
                Канал "{{  $channel['name']}}" <br>
                Всего просмотров: {{ $channel['views'] }} <br>
                Всего Лайков: {{ $channel['likes'] }} <br>
                Всего Дизлайков: {{ $channel['dislikes'] }} <br>
            </p>
        @else
            <p>Ничего не найдено</p>
        @endif
    </div>
</div>
