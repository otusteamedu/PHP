<div class="card">
    <div class="card-body">
        <form class="" action="/get">
            <div class="row">
                <div class="col col-md-6">
                    <input type="text" class="form-control" name="q" value="{{ $search }}" placeholder="Search channel">
                </div>
                <div class="col col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
                <div class="col col-md-3">
                    <a href="{{ route('getTop') }}" class="btn btn-outline-danger"> Get top </a>
                </div>
            </div>
        </form>
        <?php if (!empty($channel)) : ?>
        Канал "{{  $channel['name']}}" <br>
        Всего просмотров: {{ $channel['views'] }} <br>
        Лайков: {{ $channel['likes'] }} <br>
        Дизлайков: {{ $channel['dislikes'] }} <br>
        <?php else: ?>
        Ничего не найдено
        <?php endif; ?>
    </div>
</div>
