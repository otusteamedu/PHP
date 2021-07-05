<form class="">
    <div class="row">
        <div class="col col-md-9">
            <input type="text" class="form-control" name="q" value="{{ $search ?? '' }}" placeholder="Search channels">
        </div>
        <div class="col col-md-3">
            <button type="submit" class="btn btn-primary btn-block">Search</button>
        </div>
    </div>
</form>
