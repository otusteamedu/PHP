<div class="card" style="margin: 100px">
    <div class="card-body">
        <span class="card-title" style="font-size: 18px; margin: 25px"> Add new event </span>
        <form method="POST" action="/store">
            @csrf
            <div class="row" style="margin: 25px">
                <div class="col col-md-6">
                    Priority
                    <input type="text" class="form-control" name="event[priority]" placeholder="priority">
                </div>
            </div>
            <div id="conditions">
                <div class="row" style="margin: 25px">
                    <div class="col col-md-2">
                        <input type="text" class="form-control" name="event[conditions][1][key]" placeholder="key">
                    </div>
                    <div class="col col-md-2">
                        <input type="text" class="form-control" name="event[conditions][1][value]" placeholder="value">
                    </div>
                    <div class="col col-md-2">
                        <button type="button" class="btn btn-outline-primary add">Add condition</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col col-md-6">
                    event
                    <input type="text" class="form-control" name="event[event_name]" placeholder="event">
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col col-md-2">
                    <button type="submit" class="btn btn-danger">Store event</button>
                </div>
            </div>
        </form>
    </div>
</div>
@once
    @push('scripts')
        <script>
            let i = 1;

            $(".add").click(function () {
                ++i;
                $("#conditions").append('<div class="row" style="margin: 25px"><div class="col col-md-2">' +
                    '<input type="text" class="form-control" name="event[conditions]['+ i +'][key]" placeholder="key">' +
                    '</div><div class="col col-md-2">' +
                    '<input type="text" class="form-control" name="event[conditions]['+ i +'][value]" placeholder="value">' +
                    '</div><div class="col col-md-2">');
            });
            $(document).on('click', '.remove-tr', function () {
                $(this).parents('tr').remove();
            });
        </script>
    @endpush
@endonce
